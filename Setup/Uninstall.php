<?php
namespace Codilar\HelloWorld\Setup;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\SalesRule\Model\RuleFactory;
use \Psr\Log\LoggerInterface;
class Uninstall implements UninstallInterface
{
    /**
     * @var RuleFactory
     */
    private $ruleFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Uninstall constructor.
     * @param RuleFactory $ruleFactory
     * @param LoggerInterface $logger
     */
    public function __construct (RuleFactory $ruleFactory,LoggerInterface $logger)
    {
        $this->ruleFactory = $ruleFactory;
        $this->logger = $logger;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->debug ('Uninstall file run');
        $goldClubRule=$this->ruleFactory->create ();
        $updateRule=$goldClubRule->load (5);
        $updateRule->setConditionsSerialized ('');
        $updateRule->save();
    }
}