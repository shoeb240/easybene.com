<?php
class My_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $page = $request->getControllerName();

        $pages = array(
            array(
                'label'      => 'Home',
                'title'      => 'Go Home',
                'uri'       => '/index',
                'class'      => ($page == 'index' ? 'topmenu_active' : ''),
                'order'      => -100 // make sure home is the first page
                
            ),
            array(
                'label'      => 'PROJECTS',
                'uri'       => '/project/index',
                'class'      => ($page == 'project' ? 'topmenu_active' : ''),
                'pages'      => array(
                    array(
                        'label'      => 'SUBMIT PROJECT',
                        'uri'       => '/project/project-submit',
                        'resource'   => 'mvc:project.submit'),
                    array(
                        'label'      => 'PROJECT LISTING',
                        'uri'       => '/project/index',
                        'resource'   => 'mvc:project.listing'),
                    array(
                        'label'      => 'ACTIVE PROJECTS',
                         'uri'       => '/project/active-projects',
                        'resource'   => 'mvc:project.active'),
                    array(
                        'label'      => 'FEEDBACK',
                        'uri'       => '/project/feedbacks-by-me',
                        'resource'   => 'mvc:project.feedbacks'),
                    array(
                        'label'      => 'ARCHIVE',
                        'uri'       => '/project/archive-projects',
                        'resource'   => 'mvc:project.archive'),
                )
            ),
            array(
                'label'      => 'MEMBER LIST',
                'uri'       => '/member/index',
                'class'      => ($page == 'member' ? 'topmenu_active' : ''),
                'pages'      => array(
                    array(
                        'label'      => 'FEATURED',
                        'uri'       => '/member/featured-members'),
                    array(
                        'label'      => 'MEMBER LISTING',
                        'uri'       => '/member/index'),
                    array(
                        'label'      => 'CURRENT HIRES',
                        'uri'       => '/member/current-hired-members',
                        'resource'   => 'mvc:member.hired'),
                    array(
                        'label'      => 'BOOKMARKS',
                        'uri'       => '/member/bookmarks',
                        'resource'   => 'mvc:member.bookmarks')
                )
            ),
            array(
                'label'      => 'MY ACCOUNT',
                'uri'       => '/account/profile',
                'class'      => ($page == 'account' ? 'topmenu_active' : ''),
                'resource'   => 'mvc:account',
                'pages'      => array(
                    array(
                        'label'      => 'INBOX',
                        'uri'       => '/account/inbox'),
                    array(
                        'label'      => 'OUTBOX',
                        'uri'       => '/account/outbox'),
                    array(
                        'label'      => 'EDIT PROFILE',
                        'uri'       => '/account/edit-profile'),
                    array(
                        'label'      => 'VIEW PROFILE',
                        'uri'       => '/account/profile'),
                    array(
                        'label'      => 'MY PORTFOLIO',
                        'uri'       => '/account/portfolio')
                )
            )
        );
        
        $view = new Zend_View();
        
        $container = new Zend_Navigation($pages);
        $view->getHelper('navigation')->setContainer($container);
        $navigation = $view->navigation()->menu();
        $view->placeholder('navigation')->set($navigation);
        
        // Setup ACL:
        $acl = new Zend_Acl();
        $acl->addRole(new Zend_Acl_Role('guest'));
        $acl->addRole(new Zend_Acl_Role('member'));
        $acl->add(new Zend_Acl_Resource('mvc:project.submit'));
        $acl->add(new Zend_Acl_Resource('mvc:project.listing'));
        $acl->add(new Zend_Acl_Resource('mvc:project.active'));
        $acl->add(new Zend_Acl_Resource('mvc:project.feedbacks'));
        $acl->add(new Zend_Acl_Resource('mvc:project.archive'));
        $acl->add(new Zend_Acl_Resource('mvc:member.hired'));
        $acl->add(new Zend_Acl_Resource('mvc:member.bookmarks'));
        $acl->add(new Zend_Acl_Resource('mvc:account'));
        
        
        $acl->allow('member', array('mvc:project.submit', 'mvc:project.listing',
                                    'mvc:project.active', 'mvc:project.feedbacks',
                                    'mvc:project.archive', 'mvc:member.hired',
                                    'mvc:member.bookmarks', 'mvc:account'));

        Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
        
        $role = 'guest';
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $role = 'member';
        }
        Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($role);
        

    }
 
}