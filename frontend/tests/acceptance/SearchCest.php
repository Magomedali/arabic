<?php
namespace frontend\tests\acceptance;

use \AcceptanceTester;

class SearchCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        
        $I->wantTo('search information about codeception');

        $I->amOnPage("/");

        $I->see('Найти');

        $I->fillField("input[name=text]","Codeception");
        
        if(method_exists($I, 'wait')){
            $I->wait(1); //only for selenium
        }

        $I->click("button[type=submit]");

        if(method_exists($I, 'wait')){
            $I->wait(3); //only for selenium
        }

        $I->seeInCurrentUrl('/search/?');
        $I->see("тестирование");
        
    }
}
