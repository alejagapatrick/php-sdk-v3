<?php

namespace Cardpay\test\recurring\scheduled;

use Cardpay\ApiException;
use Cardpay\test\BaseTestCase;
use Cardpay\test\Config;
use DateTime;

class RecurringGracePeriodScheduledTest extends BaseTestCase
{
    /**
     * @throws ApiException
     */
    public function testScheduledSubscriptionWithGracePeriod()
    {
        // create new plan
        $recurringPlanUtils = new RecurringPlanUtils();
        $recurringPlanResponse = $recurringPlanUtils->createPlan(Config::$gatewayTerminalCode, Config::$gatewayPassword);
        $planId = $recurringPlanResponse->getPlanData()->getId();

        // create scheduled subscription with grace period (one month)
        $subscriptionStartDateTime = new DateTime('+1 month');
        $subscriptionStart = $subscriptionStartDateTime->format("Y-m-d\TH:i:s\Z");

        $recurringScheduledUtils = new RecurringScheduledUtils(Config::$gatewayTerminalCode, Config::$gatewayPassword);
        $redirectUrl = $recurringScheduledUtils->createScheduledSubscriptionInGatewayMode(time(), $planId, $subscriptionStart);

        self::assertNotEmpty($redirectUrl);
    }
}