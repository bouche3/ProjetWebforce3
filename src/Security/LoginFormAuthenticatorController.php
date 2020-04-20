<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


abstract class LoginFormAuthenticatorController extends AbstractFormLoginAuthenticator
{


    use TargetPathTrait;

    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager,
                                RouterInterface $router,
                                CsrfTokenManagerInterface $csrfTokenManager,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager=$entityManager;
        $this->router=$router;
        $this->csrfTokenManager=$csrfTokenManager;
        $this->passwordEncoder=$passwordEncoder;
    }
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
       return 'app_user_register'===$request->attributes->get('route')
           && $request->isMethod('POST');
    }
    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        $credentials=[
            'email'=>$request->request->get('email'),
           ' password'=>$request->request->get('password'),
            'csrf_token'=>$request->get('csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );
        return $credentials;
    }

//UserProviderInterface: Represents a class that loads UserInterface objects from some source for the authentication system.
// In a typical authentication configuration, a username (i.e. some unique user identifier) credential enters the system
// (via form login, or any method). The user provider that is configured with that authentication method is asked to load
// the UserInterface object for the given username (via loadUserByUsername) so that the rest of the process can continue.
// Internally, a user provider can load users from any source (databases,configuration, web service).
public function getUser($credentials, UserProviderInterface $userProvider)
    {

        $token=new CsrfToken('authenticate',$credentials['csrf_token']);
        if(!$this->csrfTokenManager->isTokenValid($token))
        {
            throw new InvalidCsrfTokenException();
        }
        $user=$this->entityManager->getRepository(User::class)->findOneBy(
            ['email'=>$credentials['email']]);
        if(!$user)
        {
            //fail authentication
            throw new CustomUserMessageAuthenticationException('Email could not be found');
        }
        return $user;
    }

    //checks if the given credentials are valid
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user,$credentials['password']);
    }

    //if the authentication is success it redirects to the respected url.
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if($targetPath=$this->getTargetPath($request->getSession(),$providerKey))
        {
            return new RedirectResponse($targetPath);
        }
        return new RedirectResponse($this->router->generate('app_index_index'));
    }
      protected function getLoginUrl()
    {
       return $this->router->generate('app_user_login');
    }
}
