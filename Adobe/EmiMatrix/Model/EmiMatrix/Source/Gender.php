<?php

namespace Adobe\EmiMatrix\Model\EmiMatrix\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Gender implements OptionSourceInterface
{
    /**
     * Gender
     */
    const MALE = '1';
    const FEMALE = '2';

    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return[
            [
                'value' => self::MALE,
                'label' => __('Male')
            ],
            [
                'value' => self::FEMALE,
                'label' => __('Female')
            ]
        ];
    }
}
