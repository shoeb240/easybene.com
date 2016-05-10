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
                'route'      => 'indexIndex',
                'class'      => ($page == 'index' ? 'topmenu_active' : ''),
                'order'      => -100 // make sure home is the first page
                
            ),
            array(
                'label'      => 'PROJECTS',
                'route'      => 'indexProject',
                'class'      => ($page == 'project' ? 'topmenu_active' : ''),
                'pages'      => array(
                    array(
                        'label'      => 'SUBMIT PROJECT',
                        'route'      => 'projectSubmit',
                        'resource'   => 'mvc:project.submit'),
                    array(
                        'label'      => 'PROJECT LISTING',
                        'route'      => 'indexProject',
                        'resource'   => 'mvc:project.listing'),
                    array(
                        'label'      => 'ACTIVE PROJECTS',
                        'route'      => 'activeProjects',
                        'params'     => array('searchType' => 'latest'),
                        'resource'   => 'mvc:project.active'),
                    array(
                        'label'      => 'FEEDBACK',
                        'route'      => 'feedbacksByMe',
                        'resource'   => 'mvc:project.feedbacks'),
                    array(
                        'label'      => 'ARCHIVE',
                        'route'      => 'archiveProjects',
                        'params'     => array('searchType' => 'latest'),
                        'resource'   => 'mvc:project.archive'),
                )
            ),
            array(
                'label'      => 'MEMBER LIST',
                'route'      => 'indexMembers',
                'class'      => ($page == 'member' ? 'topmenu_active' : ''),
                'pages'      => array(
                    array(
                        'label'      => 'FEATURED',
                        'route'      => 'featuredMembers'),
                    array(
                        'label'      => 'MEMBER LISTING',
                        'route'      => 'indexMembers'),
                    array(
                        'label'      => 'CURRENT HIRES',
                        'route'      => 'currentHiredMembers',
                        'resource'   => 'mvc:member.hired'),
                    array(
                        'label'      => 'BOOKMARKS',
                        'route'      => 'bookmarksMembers',
                        'resource'   => 'mvc:member.bookmarks')
                )
            ),
            array(
                'label'      => 'MY ACCOUNT',
                'route'      => 'profile',
                'class'      => ($page == 'account' ? 'topmenu_active' : ''),
                'resource'   => 'mvc:account',
                'pages'      => array(
                    array(
                        'label'      => 'INBOX',
                        'route'      => 'inbox'),
                    array(
                        'label'      => 'OUTBOX',
                        'route'      => 'outbox'),
                    array(
                        'label'      => 'EDIT PROFILE',
                        'route'      => 'editProfile'),
                    array(
                        'label'      => 'VIEW PROFILE',
                        'route'      => 'profile'),
                    array(
                        'label'      => 'MY PORTFOLIO',
                        'route'      => 'portfolio')
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