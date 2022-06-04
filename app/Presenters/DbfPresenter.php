<?php namespace App\Presenters;

class DbfPresenter extends Presenter {

    /**
     * Present a link to the user's gravatar
     *
     * @param int $size
     * @return string
     */
    public function KEY()
    {
        if(!isset($this->entity->getAttributes()["KEY"])){
            return null;
        }
        $pad_length = 13;
        $pad_char = 0;
        $key = $this->entity->getAttributes()["KEY"];

        return str_pad($key, $pad_length, $pad_char, STR_PAD_LEFT);
    }

      public function listprice()
    {
        return "$ " . $this->entity->getAttributes()["LISTPRICE"];
    }

}