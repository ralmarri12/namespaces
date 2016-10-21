<?php

namespace Greedy\Component;
/**
 * @ auth: Rashid F.
 * @lastupdated 21/10/2016
 */
abstract Component
{
    private     $request,
                $table_discription;

    protected   $name,
                $display_name;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    function install()
    {
        // TODO define Component->install()
    }

    /**
    * @param void
    * @return array
    */
    abstract function describe_table();

    
}
