<?php
namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use http\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\KernelInterface;


class AnonymousContext implements Context
{

    private ?KernelBrowser $client;
    private ?array $responseData;

    public function __construct(private KernelInterface $kernel)
    {
        $this->client = new KernelBrowser($this->kernel);
    }

    /**
     * @return void
     * @BeforeScenario
     */
    function avantChaqueScenario(){
        $_SERVER['DEFAULT_URI'] = 'http://localhost:8080/';
        $_SERVER['CORS_ALLOW_ORIGIN'] = "*";
        $_SERVER['JWT_SECRET_KEY'] = "secret";
        $_SERVER['JWT_PUBLIC_KEY'] = "secret";
        $_SERVER['JWT_PASSPHRASE'] = "secret";

        $this->responseData = [];
    }

    /**
     * @When j'envoie une requête http GET sur :url sans être authentifié
     */
    public function jenvoieUneRequetHttpSansEtreAuthentife(string $url): void {



        $this->client->request(
            'GET',
            $url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->responseData = json_decode(
            $this->client->getResponse()->getContent(),
            true
        );

    }

    /**
     * @return void
     * @Then le code de réponse est :code
     */
    public function leCodeDeReponseEst(int $code):void{
        $actualCode = $this->client->getResponse()->getStatusCode();
        if($actualCode != $code){
            throw new RuntimeException(
                "codes attendu : {$code}, reçu : {$actualCode}"
            );
        }
    }

}