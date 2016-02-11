<?php
// src/ComentsBundle/Services/GitHub.php

namespace ComentsBundle\Services;

class GitHub
{

  private $buzz;

  public function __construct(\Buzz\Browser $buzz)
  {
    $this->buzz = $buzz;
  }

  /**
   * retourne une liste d'utilisateur 
   *
   * @param string $patern
   * @return ListOfUsers
   */
  public function searchUsers($patern)
  {
    
    $response = $this->buzz->get('https://api.github.com/search/users?q='.$patern);


	return json_decode($response->toDomDocument()->textContent)->items;
  }
  
  public function searchRepos($user)
  {
    
    $response = $this->buzz->get('https://api.github.com/users/'.$user.'/repos');


	return json_decode($response->toDomDocument()->textContent);
  }
}