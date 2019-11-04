<?php

namespace Magerex\FixRules\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\SalesRule\Model\RuleFactory;
use \Psr\Log\LoggerInterface;

class InstallData implements InstallDataInterface
{
    protected $_postFactory;
    /**
     * @var \Magento\SalesRule\Model\RuleFactory
     */
    private $ruleFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * InstallData constructor.
     * @param RuleFactory $ruleFactory
     * @param LoggerInterface $logger
     */
    public function __construct(RuleFactory $ruleFactory,LoggerInterface $logger)
    {

        $this->ruleFactory = $ruleFactory;
        $this->logger = $logger;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->debug('Install file run');
        $goldClubRule=$this->ruleFactory->create ();
        $updateRule=$goldClubRule->load (5);
        $defaultCondition=json_decode($updateRule->getActionsSerialized(),true);
        $defaultCondition['value'] = "0";
        $newCondition['conditions'][] = [
            'type' => 'Magento\SalesRule\Model\Rule\Condition\Address',
            'attribute' => 'payment_method',
            'operator' => "==",
            'value' => "checkmo",
            'is_value_processed' =>false
        ];
        $conditionsMerged=array_merge ($defaultCondition,$newCondition);
        $condition=json_encode ($conditionsMerged);
        $updateRule->setConditionsSerialized($condition);
        $updateRule->save();
    }
}
