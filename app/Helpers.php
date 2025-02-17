
<?php

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

if (!function_exists('resource_to_array')) {
    /**
     * Convert a Laravel API Resource object or collection to an array.
     *
     * @param JsonResource $resource
     * @return array
     */
    function resource_to_array(JsonResource $resource): array
    {
        return $resource->toArray(request());
    }

}
