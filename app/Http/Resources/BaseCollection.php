<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    public static $wrap = 'results';

    protected $code = 200;

    protected $message = 'success';

    /**
     * BaseCollection constructor.
     * @param $resource
     * @param string|null $collects The class name of resource to be collected
     */
    public function __construct($resource, $collects = null)
    {
        if(!is_null($collects)) {
            $this->collects = $collects;
        }

        parent::__construct($resource);
    }

    public function with ($request)
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }

    public function setCode ($code, $message = null)
    {
        $this->code = $code;

        if(!is_null($message)) {
            $this->message = $message;
        }
    }
}
