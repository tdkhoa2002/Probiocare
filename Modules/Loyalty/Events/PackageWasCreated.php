<?php

namespace Modules\Loyalty\Events;

use Modules\Loyalty\Entities\Package;
use Modules\Media\Contracts\StoringMedia;

class PackageWasCreated implements StoringMedia
{

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $data;
    public $package;
    public function __construct(Package $package, array $data)
    {
        //
        $this->data = $data;
        $this->package = $package;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->package;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
