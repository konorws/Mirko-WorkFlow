<?php

namespace App\Service\Attachment\Thumb;

use App\Entity\Attachment\Attachment;
use App\Service\Attachment\AttachmentService;

/**
 * Interface ThumbInterface
 * @package App\Service\Attachment\Thumb
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class ImageThumb implements ThumbInterface
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    /**
     * ImageThumb constructor.
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @param Attachment $attachment
     *
     * @return string
     */
    public function buildThumbUrl(Attachment $attachment): string
    {
        return  $this->attachmentService->getPublicUrl($attachment);
    }
}
