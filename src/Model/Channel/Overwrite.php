<?php

namespace Ourted\Model\Channel;


class Overwrite
{

    public $id;
    public $type;
    public $allow;
    public $deny;


    /**
     * @param int|string $id
     * @param int $type
     * @param array $allow
     * @param array $deny

     */
    public function __construct($id, $type, $allow = array(), $deny = array())
    {
        $this->id = $id;
        $this->type = $type;
        $n_allow = 0;
        $n_deny = 0;
        if(is_array($allow)) foreach ($allow as $item) $n_allow += $item;
        else $n_allow = $allow;
        if(is_array($deny)) foreach ($deny as $item) $n_deny += $item;
        else $n_deny = $deny;
        $this->allow = $n_allow;
        $this->deny = $n_deny;
    }

    public function create_object()
    {
        return json_encode([
            "id" => $this->id,
            "type" => $this->type,
            "allow" => $this->allow,
            "deny" => $this->deny
        ]);
    }

}