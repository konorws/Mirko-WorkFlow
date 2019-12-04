<?php

namespace App\Twig\Attachment;

use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Attachment\Attachment;
use Twig\Extension\AbstractExtension;
use App\Service\Attachment\AttachmentService;

/**
 * Class AttachmentThumbExtension
 * @package App\Twig\Attachment
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class AttachmentThumbExtension extends AbstractExtension
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    /**
     * AttachmentThumbExtension constructor.
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return array|\Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('attachmentThumb', [$this, 'attachmentThumb'],
                [
                    'is_safe' => ['html']
                ]
            )
        ];
    }

    /**
     * @param Attachment|null $attachment
     *
     * @return string
     * @throws \App\Exception\UndefinedErrorException
     */
    public function attachmentThumb(?Attachment $attachment = NULL)
    {
        return $this->attachmentService->buildThumbUrl($attachment);
    }
}
