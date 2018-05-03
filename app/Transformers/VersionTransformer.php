<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Version;


class VersionTransformer extends TransformerAbstract
{
    public function transform(Version $Version)
    {
        return [
            'id' => (int)$Version->id,
            'version' => $Version->version,
            'updated' => (string)$Version->updated,
            'name' => (string)$Version->name,
            'phone' => (string)$Version->phone


        ];
    }
}
