<?php

namespace App\Service\Attachment\Thumb;

use App\Entity\Attachment\Attachment;
use App\Service\Attachment\AttachmentService;
use App\ObjectValue\Attachment\CategoryThumbObjectValue;

/**
 * Interface UndefinedThumb
 * @package App\Service\Attachment\Thumb
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class UndefinedThumb implements ThumbInterface
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
     * @param NULL|Attachment $attachment
     *
     * @return string
     */
    public function buildThumbUrl(?Attachment $attachment): string
    {
        $imageName = CategoryThumbObjectValue::DEFAULT;
        if($attachment !== NULL
            && CategoryThumbObjectValue::hasKeyExist($attachment->getCategory())
        ) {
            $imageName = CategoryThumbObjectValue::get($attachment->getCategory());
        }

        return $imageName;
    }
}
