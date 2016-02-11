<?php

namespace ComentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use ComentsBundle\Entity\Comments;

class DefaultController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
	    if($request->isMethod('POST')) {
			$gitHub = $this->container->get('git_hub');
			
			$patern = str_replace(" ","&",ltrim($request->request->get('patern')));
			
			$users = $gitHub->searchUsers($patern);
			
			return $this->render('ComentsBundle:Default:listUsers.html.twig',array('users' => $users));
		}	
		
        return $this->render('ComentsBundle:Default:index.html.twig');
    }
	
	/**
     * @Security("has_role('ROLE_USER')")
     */
	public function userAction($username,Request $request){
	
	     // On récupère l'EntityManager
		$em = $this->getDoctrine()->getManager();
	
	    if($request->isMethod('POST')) {
			$repo = explode("/",$request->request->get('repo'));
			$commentaire = $request->request->get('comment');
			
			$comment = new Comments();
			$comment->setUser($repo[0]);
		    $comment->setRepo($repo[1]);
			$comment->setComment($commentaire);
			
			$em->persist($comment);
			
			$em->flush();
		}	
	
	    $gitHub = $this->container->get('git_hub');
		
		$repos = $gitHub->searchRepos($username);
		
		$repository = $em->getRepository('ComentsBundle:Comments');
		
		$listComments = $repository->findBy(
		  array('user' => $username),
		  array('date' => 'desc'),
		  5,0);
		
		return $this->render('ComentsBundle:Default:user.html.twig',array('repos' => $repos,'username' => $username, 'listComments' =>$listComments));
	}
}
