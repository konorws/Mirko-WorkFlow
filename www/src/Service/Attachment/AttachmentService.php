<?php

namespace App\Service\Attachment;

use App\Service\Attachment\Thumb\ThumbInterface;
use Doctrine\ORM\EntityRepository;
use App\Service\KeyGeneratorService;
use App\Entity\Attachment\Attachment;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\UndefinedErrorException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AttachmentService
 * @package App\Service\Attachment
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class AttachmentService
{
    CONST TYPE_IMAGE = 'image';
    CONST TYPE_DOCUMENT = 'document';

    CONST FOLDER = '/user_upload/';

    /**
     * @var EntityRepository
     */
    protected $attachmentRepository;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    private $types = [
        self::TYPE_IMAGE => [
            'image/png', 'image/jpeg', 'image/jpg', 'image/svg'
        ],
    ];

    /**
     * AttachmentService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     */
    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->attachmentRepository = $entityManager->getRepository(Attachment::class);
    }

    /**
     * @param UploadedFile $file
     * @param string $category
     *
     * @return Attachment
     *
     * @throws UndefinedErrorException
     */
    public function saveUploaded(UploadedFile $file, string $category = "undefined"): Attachment
    {
        $type = $this->getTypeByMineType($file->getMimeType());

        $attachment = Attachment::create(
            $file->getClientOriginalName(),
            $file->getMimeType(),
            $this->getFolderPath($type, $category),
            $this->generateFileName($file),
            $category,
            $type
        );

        $this->saveFile($file, $attachment);

        $this->entityManager->persist($attachment);
        $this->entityManager->flush();

        return $attachment;
    }

    /**
     * @param Attachment $attachment
     */
    public function removeAttachment(Attachment $attachment)
    {
        if(file_exists($this->getFullPathToAttachment($attachment))) {
            unlink($this->getFullPathToAttachment($attachment));
        }

        $this->entityManager->remove($attachment);
        $this->entityManager->flush();
    }

    /**
     * @param Attachment $attachment
     * @return string
     */
    public function getFullPathToAttachment(Attachment $attachment)
    {
        return $this->container->getParameter("kernel.project_dir") . "/public"
            . $this->getPublicUrl($attachment);
    }

    /**
     * @param Attachment $attachment
     *
     * @return string
     */
    public function getPublicUrl(Attachment $attachment)
    {
        return $attachment->getFolderPath() . $attachment->getFileName();
    }

    /**
     * @param UploadedFile $file
     * @param string $type
     *
     * @return bool
     */
    public function validateFile(UploadedFile $file, string $type)
    {
        if(!$file->isValid()) {
            return false;
        }

        if(!isset($this->types[$type])) {
            return false;
        }

        return in_array($file->getMimeType(), $this->types[$type]);
    }

    /**
     * @param Attachment|null $attachment
     *
     * @return string
     *
     * @throws UndefinedErrorException
     */
    public function buildThumbUrl(?Attachment $attachment)
    {
        $thumbType = "Undefined";
        if($attachment !== NULL) {
            $thumbType = ucfirst($attachment->getType());
        }

        $class = $this->getThumbClass($thumbType);
        if(!class_exists($class)) {
            $class = $this->getThumbClass("Undefined");
        }

        /** @var ThumbInterface $thumbObject */
        $thumbObject = new $class($this);

        if(!$thumbObject instanceof ThumbInterface) {
            throw new UndefinedErrorException("Invalid class <{$class}>. Must implement: ". ThumbInterface::class );
        }

        return $thumbObject->buildThumbUrl($attachment);
    }

    /**
     * @param string $thumbType
     * @return string
     */
    private function getThumbClass(string $thumbType): string
    {
        return "\\App\\Service\\Attachment\\Thumb\\{$thumbType}Thumb";
    }

    /**
     * @param UploadedFile $file
     * @param Attachment $attachment
     *
     * @throws UndefinedErrorException
     */
    private function saveFile(UploadedFile $file, Attachment $attachment)
    {
        try {
            copy($file->getPathname(), $this->getFullPathToAttachment($attachment));
        } catch (\Exception $exception) {
            throw new UndefinedErrorException($exception->getMessage());
        }
    }

    /**
     * Generate uniq name for file
     *
     * @param UploadedFile $file
     *
     * @return int|string
     */
    private function generateFileName(UploadedFile $file)
    {
        $fileName = time();
        $fileName .= ".".KeyGeneratorService::generateKey(15);
        $fileName .= ".".$file->getClientOriginalExtension();

        return strtolower($fileName);
    }

    /**
     * Build folder path for file and create folder
     *
     * @param string $type
     * @param string $category
     *
     * @return string
     *
     * @throws UndefinedErrorException
     */
    private function getFolderPath(string $type, string $category)
    {
        $folder = self::FOLDER
        . $type . "/"
        . $category . "/";

        $fullPath = $this->container->getParameter("kernel.project_dir") . "/public" . $folder;
        if(!is_dir($fullPath)) {
            if(!mkdir($fullPath, 0777, true)) {
                throw new UndefinedErrorException("Failed to create a directory to save the file <{$folder}>");
            }
        }

        return $folder;
    }

    /**
     * @param string $mineType
     * @return string
     */
    private function getTypeByMineType(string $mineType)
    {
        foreach ($this->types as $type => $mineTypes) {
            if(in_array($mineType, $mineTypes)) {
                return $type;
            }
        }

        return "undefined";
    }
}
