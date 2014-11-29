<?php

class AdminMenu extends Phalcon\Mvc\User\Component
{

    public function getMenu()
    {

        $view = new Phalcon\Mvc\View\Simple();

        $view->setViewsDir('../app/modules/admin/views/');
//        echo $this->view->render('index', array('posts' => Posts::find()));
        echo $view->render("widgets/menu");
    }

}
