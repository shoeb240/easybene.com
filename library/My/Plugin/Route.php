<?php
class My_Plugin_Route extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->addDefaultRoutes();

        $route = new Zend_Controller_Router_Route('auth/:act',
                                                  array('controller' => 'auth', 'act' => 'login'));
        $router->addRoute('indexAuth', $route);
        
        $route = new Zend_Controller_Router_Route('api/:username/:token/:id',
                                          array('controller' => 'api', 'action' => 'index', 'id' => null));
        $router->addRoute('indexApi', $route);

        $route = new Zend_Controller_Router_Route('upload/:username/:token/:id',
                                  array('controller' => 'upload', 'action' => 'index', 'id' => null));
        $router->addRoute('indexUpload', $route);
        
        $route = new Zend_Controller_Router_Route('api-user/:username/:token/:id',
                                  array('controller' => 'api-user', 'action' => 'index', 'id' => null));
        $router->addRoute('indexApiUser', $route);
        
        $route = new Zend_Controller_Router_Route('api-medical/:username/:token/:id',
                                  array('controller' => 'api-medical', 'action' => 'index', 'id' => null));
        $router->addRoute('indexApiMedical', $route);
        
        $route = new Zend_Controller_Router_Route('api-dental/:username/:token/:id',
                                  array('controller' => 'api-dental', 'action' => 'index', 'id' => null));
        $router->addRoute('indexApiDental', $route);
        
        $route = new Zend_Controller_Router_Route('api-summary/:username/:token/:id',
                                  array('controller' => 'api-summary', 'action' => 'index', 'id' => null));
        $router->addRoute('indexApiSummary', $route);

        $route = new Zend_Controller_Router_Route('api-funds/:username/:token/:id',
                                  array('controller' => 'api-funds', 'action' => 'index', 'id' => null));
        $router->addRoute('indexApiFunds', $route);
        
        $route = new Zend_Controller_Router_Route('api-id-card/:username/:token/:id',
                                  array('controller' => 'api-id-card', 'action' => 'index', 'id' => null));
        $router->addRoute('indexApiIdCard', $route);
        
        
        $route = new Zend_Controller_Router_Route('scrape-cigna/:action/:username/:token/:id',
                                                  array('controller' => 'scrape-cigna',
                                                        'action' => 'execute'));
        $router->addRoute('indexCignaScrape', $route);
        $route = new Zend_Controller_Router_Route('scrape-cigna/:action/:user_id',
                                                  array('controller' => 'scrape-cigna',
                                                        'action' => 'execute'));
        $router->addRoute('indexCignaScrapeCron', $route);
        
        
        $route = new Zend_Controller_Router_Route('scrape-guardian/:action/:username/:token/:id',
                                                  array('controller' => 'scrape-guardian',
                                                        'action' => 'execute'));
        $router->addRoute('indexGuardianScrape', $route);
        $route = new Zend_Controller_Router_Route('scrape-guardian/:action/:user_id',
                                                  array('controller' => 'scrape-guardian',
                                                        'action' => 'execute'));
        $router->addRoute('indexGuardianScrapeCron', $route);
        
        
        $route = new Zend_Controller_Router_Route('scrape-anthem/:action/:username/:token/:id',
                                                  array('controller' => 'scrape-anthem',
                                                        'action' => 'execute'));
        $router->addRoute('indexAnthemScrape', $route);
        $route = new Zend_Controller_Router_Route('scrape-anthem/:action/:user_id',
                                                  array('controller' => 'scrape-anthem',
                                                        'action' => 'execute'));
        $router->addRoute('indexAnthemScrapeCron', $route);
        
        
        $route = new Zend_Controller_Router_Route('scrape-navia/:action/:username/:token/:id',
                                                  array('controller' => 'scrape-navia',
                                                        'action' => 'execute'));
        $router->addRoute('indexNaviaScrape', $route);
        $route = new Zend_Controller_Router_Route('scrape-navia/:action/:user_id',
                                                  array('controller' => 'scrape-navia',
                                                        'action' => 'execute'));
        $router->addRoute('indexNaviaScrapeCron', $route);
        

        
        $route = new Zend_Controller_Router_Route('index/paypal-payment/:userId',
                                                  array('controller' => 'index',
                                                        'action' => 'paypal-payment'));
        $router->addRoute('paypalPayment', $route);
        
        $route = new Zend_Controller_Router_Route('project/index/:searchType/:page',
                                                  array('searchType' => 'latest',
                                                        'page' => 1,
                                                        'controller' => 'project',
                                                        'action' => 'index'));
        $router->addRoute('indexProject', $route);        

        $route = new Zend_Controller_Router_Route('project/project-details/:projectId',
                                                  array('controller' => 'project',
                                                        'action' => 'project-details'));
        $router->addRoute('projectDetails', $route);
        
        $route = new Zend_Controller_Router_Route('project/project-bid/:projectId',
                                                  array('controller' => 'project',
                                                        'action' => 'project-bid'));
        $router->addRoute('projectBid', $route);
        
        $route = new Zend_Controller_Router_Route('project/assign-project/:projectId/:bidderUserId',
                                                  array('controller' => 'project',
                                                        'action' => 'assign-project'));
        $router->addRoute('assignProject', $route);

        $route = new Zend_Controller_Router_Route('project/accept-project/:projectId/:bidderUserId',
                                                  array('controller' => 'project',
                                                        'action' => 'accept-project'));
        $router->addRoute('acceptProject', $route);

        $route = new Zend_Controller_Router_Route('project/decline-project/:projectId/:bidderUserId',
                                                  array('controller' => 'project',
                                                        'action' => 'decline-project'));
        $router->addRoute('declineProject', $route);

        $route = new Zend_Controller_Router_Route('project/cancel-project/:projectId',
                                                  array('controller' => 'project',
                                                        'action' => 'cancel-project'));
        $router->addRoute('cancelProject', $route);

        $route = new Zend_Controller_Router_Route('project/delete-bid/:projectId',
                                                  array('controller' => 'project',
                                                        'action' => 'delete-bid'));
        $router->addRoute('deleteBid', $route);

        $route = new Zend_Controller_Router_Route('project/project-bid-payment/:projectId/:paymentCheck',
                                                  array('controller' => 'project',
                                                        'action' => 'project-bid-payment'));
        $router->addRoute('projectBidPayment', $route);
        
        $route = new Zend_Controller_Router_Route('project/active-projects/:searchType/:page',
                                                  array('searchType' => 'latest',
                                                        'page' => 1,
                                                        'controller' => 'project',
                                                        'action' => 'active-projects'));
        $router->addRoute('activeProjects', $route);
        
        $route = new Zend_Controller_Router_Route('project/bidded-projects/:searchType/:page',
                                                  array('searchType' => 'latest',
                                                        'page' => 1,
                                                        'controller' => 'project',
                                                        'action' => 'bidded-projects'));
        $router->addRoute('biddedProjects', $route);

        $route = new Zend_Controller_Router_Route('project/archive-projects/:searchType/:page',
                                                  array('searchType' => 'latest',
                                                        'page' => 1,
                                                        'controller' => 'project',
                                                        'action' => 'archive-projects'));
        $router->addRoute('archiveProjects', $route);
        
        $route = new Zend_Controller_Router_Route('project/archive-bidded-projects/:searchType/:page',
                                                  array('searchType' => 'latest',
                                                        'page' => 1,
                                                        'controller' => 'project',
                                                        'action' => 'archive-bidded-projects'));
        $router->addRoute('archiveBiddedProjects', $route);
        
        $route = new Zend_Controller_Router_Route('project/owner-rating/:projectId/:bidderUserId',
                                                  array('controller' => 'project',
                                                        'action' => 'owner-rating'));
        $router->addRoute('ownerRating', $route);

        $route = new Zend_Controller_Router_Route('project/bidder-rating/:projectId/:ownerUserId',
                                                  array('controller' => 'project',
                                                        'action' => 'bidder-rating'));
        $router->addRoute('bidderRating', $route);

        $route = new Zend_Controller_Router_Route('project/feedbacks-by-me/:searchType/:page',
                                                  array('searchType' => 'latest',
                                                        'page' => 1,
                                                        'controller' => 'project',
                                                        'action' => 'feedbacks-by-me'));
        $router->addRoute('feedbacksByMe', $route);

        $route = new Zend_Controller_Router_Route('project/feedbacks-for-me/:searchType/:page',
                                                  array('searchType' => 'latest',
                                                        'page' => 1,
                                                        'controller' => 'project',
                                                        'action' => 'feedbacks-for-me'));
        $router->addRoute('feedbacksForMe', $route);

        $route = new Zend_Controller_Router_Route('project/invite-member/:projectId',
                                                  array('controller' => 'project',
                                                        'action' => 'invite-member'));
        $router->addRoute('inviteMember', $route);

        $route = new Zend_Controller_Router_Route('project/invite-member/:projectId/:userId',
                                                  array('controller' => 'project',
                                                        'action' => 'invite-member'));
        $router->addRoute('inviteMember2', $route);

        $route = new Zend_Controller_Router_Route('account/profile/:username',
                                                  array('controller' => 'account',
                                                        'action' => 'profile'));
        $router->addRoute('profile', $route);
        
        $route = new Zend_Controller_Router_Route('account/testimonials/:username',
                                                  array('controller' => 'account',
                                                        'action' => 'testimonials'));
        $router->addRoute('testimonials', $route);

        $route = new Zend_Controller_Router_Route('account/portfolio/:username',
                                                  array('controller' => 'account',
                                                        'action' => 'portfolio'));
        $router->addRoute('portfolio', $route);

        $route = new Zend_Controller_Router_Route('account/portfolio-details/:portfolioId',
                                                  array('controller' => 'account',
                                                        'action' => 'portfolio-details'));
        $router->addRoute('portfolioDetails', $route);

        $route = new Zend_Controller_Router_Route('account/delete-portfolio/:portfolioId',
                                                  array('controller' => 'account',
                                                        'action' => 'delete-portfolio'));
        $router->addRoute('deletePortfolio', $route);

        $route = new Zend_Controller_Router_Route('account/edit-portfolio/:portfolioId',
                                                  array('controller' => 'account',
                                                        'action' => 'edit-portfolio'));
        $router->addRoute('editPortfolio', $route);

        $route = new Zend_Controller_Router_Route('account/project-inbox/:projectId/:senderUserId',
                                                  array('controller' => 'account',
                                                        'action' => 'project-inbox'));
        $router->addRoute('projectInbox', $route);
        
        $route = new Zend_Controller_Router_Route('account/inbox/:page/:messageSearchUser',
                                                  array('messageSearchUser' => '',
                                                        'page' => 1,
                                                        'controller' => 'account',
                                                        'action' => 'inbox'));
        $router->addRoute('searchInbox', $route);
        
        $route = new Zend_Controller_Router_Route('account/outbox/:page/:messageSearchUser',
                                                  array('messageSearchUser' => '',
                                                        'page' => 1,
                                                        'controller' => 'account',
                                                        'action' => 'outbox'));
        $router->addRoute('searchOutbox', $route);

        $route = new Zend_Controller_Router_Route('account/delete-inbox-message/:projectId/:senderUserId',
                                                  array('controller' => 'account',
                                                        'action' => 'delete-inbox-message'));
        $router->addRoute('deleteInboxMessage', $route);

        $route = new Zend_Controller_Router_Route('account/project-outbox/:projectId/:receiverUserId',
                                                  array('controller' => 'account',
                                                        'action' => 'project-outbox'));
        $router->addRoute('projectOutbox', $route);

        $route = new Zend_Controller_Router_Route('account/delete-outbox-message/:projectId/:receiverUserId',
                                                  array('controller' => 'account',
                                                        'action' => 'delete-outbox-message'));
        $router->addRoute('deleteOutboxMessage', $route);
        
        $route = new Zend_Controller_Router_Route('member/index/:searchType/:page',
                                                  array('searchType' => 'newest',
                                                        'page' => 1,
                                                        'controller' => 'member',
                                                        'action' => 'index'));
        $router->addRoute('indexMembers', $route);

        $route = new Zend_Controller_Router_Route('member/featured-members/:searchType/:page',
                                                  array('searchType' => 'newest',
                                                        'page' => 1,
                                                        'controller' => 'member',
                                                        'action' => 'featured-members'));
        $router->addRoute('featuredMembers', $route);

        $route = new Zend_Controller_Router_Route('member/current-hired-members/:searchType/:page',
                                                  array('searchType' => 'newest',
                                                        'page' => 1,
                                                        'controller' => 'member',
                                                        'action' => 'current-hired-members'));
        $router->addRoute('currentHiredMembers', $route);

        $route = new Zend_Controller_Router_Route('member/bookmarks/:searchType/:page',
                                                  array('searchType' => 'newest',
                                                        'page' => 1,
                                                        'controller' => 'member',
                                                        'action' => 'bookmarks'));
        $router->addRoute('bookmarksMembers', $route);

        $route = new Zend_Controller_Router_Route('member/category/:categoryId/:searchType/:page',
                                                  array('searchType' => 'newest',
                                                        'page' => 1,
                                                        'controller' => 'member',
                                                        'action' => 'category'));
        $router->addRoute('categoryMembers', $route);
        
    }
}