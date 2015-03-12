<?php
namespace blogBundle\AntiSpam;

class AntiSpam
{


  private $mailer;
  private $locale;
  private $minLength;

  public function __construct(\Swift_Mailer $mailer, $locale, $minLength)
  {
    $this->mailer    = $mailer;
    $this->locale    = $locale;
    $this->minLength = (int) $minLength;
  }


	/**
   * Vérifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpamPost($text)
  {
    return strlen($text) < $this->minLength;
  }
  public function isSpamComment($text)
  {
    return strlen($text) > 2000;
  }


}