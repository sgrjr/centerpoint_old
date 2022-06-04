<?php namespace App\Presenters;

class UserPresenter extends Presenter {

    /**
     * Present a link to the user's gravatar
     *
     * @param int $size
     * @return string
     */
    public function email()
    {
        return $this->entity->EMAIL;
    }

    public function id()
    {
        return $this->entity->KEY;
    }

    /**
     * @return string
     */
    public function followerCount()
    {
        $count = $this->entity->followers()->count();
        $plural = str_plural('Follower', $count);

        return "{$count} {$plural}";
    }

    /**
     * @return string
     */
    public function statusCount()
    {
        $count = $this->entity->notes()->count();
        $plural = str_plural('Note', $count);

        return "{$count} {$plural}";
    }

}