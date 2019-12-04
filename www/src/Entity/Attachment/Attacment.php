<?php

namespace App\Entity\Attachment;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Class Project
 * @package App\Entity\Attachment
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 *
 * @ORM\Entity
 */
class Attachment
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $originName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $mineType;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $folderPath;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $fileName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $category;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected $type;

    /**
     * @param string $originName
     * @param string $mineType
     * @param string $folderPath
     * @param string $fileName
     * @param string $category
     * @param string $type
     * @return Attachment
     */
    public static function create(
        string $originName,
        string $mineType,
        string $folderPath,
        string $fileName,
        string $category,
        string $type
    ): Attachment
    {
        $attachment = new self();
        $attachment->setOriginName($originName)
            ->setMineType($mineType)
            ->setFolderPath($folderPath)
            ->setFileName($fileName)
            ->setCategory($category)
            ->setType($type);

        return $attachment;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Attachment
     */
    public function setId(int $id): Attachment
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginName(): string
    {
        return $this->originName;
    }

    /**
     * @param string $originName
     * @return Attachment
     */
    public function setOriginName(string $originName): Attachment
    {
        $this->originName = $originName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMineType(): string
    {
        return $this->mineType;
    }

    /**
     * @param string $mineType
     * @return Attachment
     */
    public function setMineType(string $mineType): Attachment
    {
        $this->mineType = $mineType;
        return $this;
    }

    /**
     * @return string
     */
    public function getFolderPath(): string
    {
        return $this->folderPath;
    }

    /**
     * @param string $folderPath
     * @return Attachment
     */
    public function setFolderPath(string $folderPath): Attachment
    {
        $this->folderPath = $folderPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return Attachment
     */
    public function setFileName(string $fileName): Attachment
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return Attachment
     */
    public function setCategory(string $category): Attachment
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Attachment
     */
    public function setType(string $type): Attachment
    {
        $this->type = $type;

        return $this;
    }
}
