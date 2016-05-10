<?php
class My_Plugin_Route extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->addDefaultRoutes();
        
        $route = new Zend_Controller_Router_Route('index/index',
                                                  array('controller' => 'index',
                                                        'action' => 'index'));
        $router->addRoute('indexIndex', $route);
        
        $route = new Zend_Controller_Router_Route('scrape/:action',
                                                  array('controller' => 'scrape',
                                                        'action' => 'execute'));
        $router->addRoute('indexScrape', $route);
        
        $route = new Zend_Controller_Router_Route('index/paypal-payment/:userId',
                                                  array('userId' => 0,
                                                        'controller' => 'index',
                                                        'action' => 'paypal-payment'));
        $router->addRoute('paypalPayment', $route);
        
        $route = new Zend_Controller_Router_Route('project/project-submit',
                                                  array('controller' => 'project',
                                                        'action' => 'project-submit'));
        $router->addRoute('projectSubmit', $route);
        
        $route = new Zend_Controller_Router_Route('project/index',
                                                  array('userId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'index'));
        $router->addRoute('indexProject', $route);        

        $route = new Zend_Controller_Router_Route('project/project-details/:projectId',
                                                  array('projectId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'project-details'));
        $router->addRoute('projectDetails', $route);

        $route = new Zend_Controller_Router_Route('project/assign-project/:projectId/:bidderUserId',
                                                  array('projectId' => 0,
                                                        'bidderUserId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'assign-project'));
        $router->addRoute('assignProject', $route);

        $route = new Zend_Controller_Router_Route('project/accept-project/:projectId/:bidderUserId',
                                                  array('projectId' => 0,
                                                        'bidderUserId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'accept-project'));
        $router->addRoute('acceptProject', $route);

        $route = new Zend_Controller_Router_Route('project/decline-project/:projectId/:bidderUserId',
                                                  array('projectId' => 0,
                                                        'bidderUserId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'decline-project'));
        $router->addRoute('declineProject', $route);

        $route = new Zend_Controller_Router_Route('project/cancel-project/:projectId',
                                                  array('projectId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'cancel-project'));
        $router->addRoute('cancelProject', $route);

        $route = new Zend_Controller_Router_Route('project/delete-bid/:projectId',
                                                  array('projectId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'delete-bid'));
        $router->addRoute('deleteBid', $route);

        $route = new Zend_Controller_Router_Route('project/project-bid-payment/:projectId/:paymentCheck',
                                                  array('projectId' => 0,
                                                        'paymentCheck' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'project-bid-payment'));
        $router->addRoute('projectBidPayment', $route);
        
        $route = new Zend_Controller_Router_Route('project/active-projects/:searchType',
                                                  array('searchType' => 'latest',
                                                        'controller' => 'project',
                                                        'action' => 'active-projects'));
        $router->addRoute('activeProjects', $route);
        
        $route = new Zend_Controller_Router_Route('project/bidded-projects/:searchType',
                                                  array('searchType' => 'latest',
                                                        'controller' => 'project',
                                                        'action' => 'bidded-projects'));
        $router->addRoute('biddedProjects', $route);

        $route = new Zend_Controller_Router_Route('project/archive-projects/:searchType',
                                                  array('searchType' => 'latest',
                                                        'controller' => 'project',
                                                        'action' => 'archive-projects'));
        $router->addRoute('archiveProjects', $route);
        
        $route = new Zend_Controller_Router_Route('project/owner-rating/:projectId/:bidderUserId',
                                                  array('projectId' => 0,
                                                        'bidderUserId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'owner-rating'));
        $router->addRoute('ownerRating', $route);

        $route = new Zend_Controller_Router_Route('project/bidder-rating/:projectId/:ownerUserId',
                                                  array('projectId' => 0,
                                                        'ownerUserId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'bidder-rating'));
        $router->addRoute('bidderRating', $route);

        $route = new Zend_Controller_Router_Route('project/feedbacks-by-me',
                                                  array('controller' => 'project',
                                                        'action' => 'feedbacks-by-me'));
        $router->addRoute('feedbacksByMe', $route);

        $route = new Zend_Controller_Router_Route('project/feedbacks-for-me/:searchType',
                                                  array('controller' => 'project',
                                                        'action' => 'feedbacks-for-me'));
        $router->addRoute('feedbacksForMe', $route);

        $route = new Zend_Controller_Router_Route('project/invite-member/:projectId',
                                                  array('projectId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'invite-member'));
        $router->addRoute('inviteMember', $route);

        $route = new Zend_Controller_Router_Route('project/invite-member/:projectId/:userId',
                                                  array('projectId' => 0,
                                                        'userId' => 0,
                                                        'controller' => 'project',
                                                        'action' => 'invite-member'));
        $router->addRoute('inviteMember2', $route);

        $route = new Zend_Controller_Router_Route('account/profile/:username',
                                                  array('username' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'profile'));
        $router->addRoute('profile', $route);
        
        $route = new Zend_Controller_Router_Route('account/edit-profile',
                                                  array('controller' => 'account',
                                                        'action' => 'edit-profile'));
        $router->addRoute('editProfile', $route);

        $route = new Zend_Controller_Router_Route('account/testimonials/:username',
                                                  array('username' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'testimonials'));
        $router->addRoute('testimonials', $route);

        $route = new Zend_Controller_Router_Route('account/portfolio/:username',
                                                  array('username' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'portfolio'));
        $router->addRoute('portfolio', $route);

        $route = new Zend_Controller_Router_Route('account/portfolio-details/:portfolioId',
                                                  array('portfolioId' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'portfolio-details'));
        $router->addRoute('portfolioDetails', $route);

        $route = new Zend_Controller_Router_Route('account/delete-portfolio/:portfolioId',
                                                  array('portfolioId' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'delete-portfolio'));
        $router->addRoute('deletePortfolio', $route);

        $route = new Zend_Controller_Router_Route('account/edit-portfolio/:portfolioId',
                                                  array('portfolioId' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'edit-portfolio'));
        $router->addRoute('editPortfolio', $route);

        $route = new Zend_Controller_Router_Route('member/index/:searchType',
                                                  array('searchType' => 'newest',
                                                        'controller' => 'member',
                                                        'action' => 'index'));
        $router->addRoute('indexMembers', $route);

        $route = new Zend_Controller_Router_Route('member/featured-members/:searchType',
                                                  array('searchType' => 'newest',
                                                        'controller' => 'member',
                                                        'action' => 'featured-members'));
        $router->addRoute('featuredMembers', $route);

        $route = new Zend_Controller_Router_Route('member/current-hired-members/:searchType',
                                                  array('searchType' => 'newest',
                                                        'controller' => 'member',
                                                        'action' => 'current-hired-members'));
        $router->addRoute('currentHiredMembers', $route);

        $route = new Zend_Controller_Router_Route('member/bookmarks/:searchType',
                                                  array('searchType' => 'newest',
                                                        'controller' => 'member',
                                                        'action' => 'bookmarks'));
        $router->addRoute('bookmarksMembers', $route);

        $route = new Zend_Controller_Router_Route('member/category/:categoryId/:searchType',
                                                  array('categoryId' => 0,
                                                        'searchType' => 'newest',
                                                        'controller' => 'member',
                                                        'action' => 'category'));
        $router->addRoute('categoryMembers', $route);

        $route = new Zend_Controller_Router_Route('account/project-inbox/:projectId/:senderUserId',
                                                  array('projectId' => 0,
                                                        'senderUserId' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'project-inbox'));
        $router->addRoute('projectInbox', $route);

        $route = new Zend_Controller_Router_Route('account/inbox',
                                                  array('controller' => 'account',
                                                        'action' => 'inbox'));
        $router->addRoute('inbox', $route);
        
        $route = new Zend_Controller_Router_Route('account/outbox',
                                                  array('controller' => 'account',
                                                        'action' => 'outbox'));
        $router->addRoute('outbox', $route);
        
        $route = new Zend_Controller_Router_Route('account/inbox/:messageSearchUser',
                                                  array('messageSearchUser' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'inbox'));
        $router->addRoute('searchInbox', $route);

        $route = new Zend_Controller_Router_Route('account/delete-inbox-message/:projectId/:senderUserId',
                                                  array('projectId' => 0,
                                                        'senderUserId' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'delete-inbox-message'));
        $router->addRoute('deleteInboxMessage', $route);

        $route = new Zend_Controller_Router_Route('account/project-outbox/:projectId/:receiverUserId',
                                                  array('projectId' => 0,
                                                        'receiverUserId' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'project-outbox'));
        $router->addRoute('projectOutbox', $route);

        $route = new Zend_Controller_Router_Route('account/delete-outbox-message/:projectId/:receiverUserId',
                                                  array('projectId' => 0,
                                                        'receiverUserId' => 0,
                                                        'controller' => 'account',
                                                        'action' => 'delete-outbox-message'));
        $router->addRoute('deleteOutboxMessage', $route);
        
    }
}