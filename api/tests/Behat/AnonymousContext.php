<?php
namespace App\Tests\Behat;

use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Behat\Behat\Tester\Exception\PendingException;
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


    #[When('a demo scenario sends a request to :arg1')]
    public function aDemoScenarioSendsARequestTo($arg1): void
    {
        throw new PendingException();
    }

    #[Then('the response should be received')]
    public function theResponseShouldBeReceived(): void
    {
        throw new PendingException();
    }


}
