<?php
/**
 * Rule
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * BeezUP API
 *
 * # The REST API of BeezUP system ## Overview The REST APIs provide programmatic access to read and write BeezUP data.  Basically, with this API you will be able to do everything like you were with your browser on https://go.beezup.com !  The main features are: - Register and manage your account - Create and manage and share your stores with your friends/co-workers. - Import your product catalog and schedule the auto importation - Search the channels your want to use - Configure your channels for your catalogs to export your product information:     - cost and general settings     - category and columns mappings     - your will be able to create and manage your custom column     - put in place exlusion filters based on simple conditions on your product data     - override product values     - get product vision for a channel catalog scope - Analyze and optimize your performance of your catalogs on all yours channels with different type of reportings by day, channel, category and by product. - Automatize your optimisation by using rules! - And of course... Manage your orders harvested from all your marketplaces:     - Synchronize your orders in an uniformized way     - Get the available actions and update the order status - ...and more!  ## Authentication credentials The public API with the base path **_/v2/public** have been put in place to give you an entry point to our system for the user registration, login and lost password. The public API does not require any credentials. We give you the some public list of values and public channels for our public commercial web site [www.beezup.com](http://www.beezup.com).  The user API with the base path **_/v2/user** requires a token which is available on this page: https://go.beezup.com/Account/MyAccount  ## Things to keep in mind ### API Rate Limits - The BeezUP REST API is limited to 100 calls/minute.  ### Media type The default media type for requests and responses is application/json. Where noted, some operations support other content types. If no additional content type is mentioned for a specific operation, then the media type is application/json.  ### Required content type The required and default encoding for the request and responses is UTF8.  ### Required date time format All our date time are formatted in ISO 8601 format: 2014-06-24T16:25:00Z.  ### Base URL The Base URL of the BeezUP API Order Management REST API conforms to the following template.  https://api.beezup.com  All URLs returned by the BeezUP API are relative to this base URL, and all requests to the REST API must use this base URL template.  You can test our API on https://api-docs.beezup.com/swagger-ui\\ You can contact us on [gitter, #BeezUP/API](https://gitter.im/BeezUP/API)
 *
 * OpenAPI spec version: 2.0
 * Contact: help@beezup.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;
use \Swagger\Client\ObjectSerializer;

/**
 * Rule Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Rule implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'rule';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'rule_id' => 'string',
        'rule_name' => 'string',
        'last_execution_status' => '\Swagger\Client\Model\RuleLastExecutionStatus',
        'last_execution_utc_date' => '\DateTime',
        'action_name' => '\Swagger\Client\Model\OptimisationActionName',
        'report_filter_id' => 'string',
        'position' => 'int',
        'enabled' => 'bool',
        'validity_start_utc_date' => '\DateTime',
        'validity_end_utc_date' => '\DateTime',
        'links' => '\Swagger\Client\Model\RuleLinks'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'rule_id' => 'guid',
        'rule_name' => null,
        'last_execution_status' => null,
        'last_execution_utc_date' => 'date-time',
        'action_name' => null,
        'report_filter_id' => 'guid',
        'position' => null,
        'enabled' => null,
        'validity_start_utc_date' => 'date-time',
        'validity_end_utc_date' => 'date-time',
        'links' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'rule_id' => 'ruleId',
        'rule_name' => 'ruleName',
        'last_execution_status' => 'lastExecutionStatus',
        'last_execution_utc_date' => 'lastExecutionUtcDate',
        'action_name' => 'actionName',
        'report_filter_id' => 'reportFilterId',
        'position' => 'position',
        'enabled' => 'enabled',
        'validity_start_utc_date' => 'validityStartUtcDate',
        'validity_end_utc_date' => 'validityEndUtcDate',
        'links' => 'links'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'rule_id' => 'setRuleId',
        'rule_name' => 'setRuleName',
        'last_execution_status' => 'setLastExecutionStatus',
        'last_execution_utc_date' => 'setLastExecutionUtcDate',
        'action_name' => 'setActionName',
        'report_filter_id' => 'setReportFilterId',
        'position' => 'setPosition',
        'enabled' => 'setEnabled',
        'validity_start_utc_date' => 'setValidityStartUtcDate',
        'validity_end_utc_date' => 'setValidityEndUtcDate',
        'links' => 'setLinks'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'rule_id' => 'getRuleId',
        'rule_name' => 'getRuleName',
        'last_execution_status' => 'getLastExecutionStatus',
        'last_execution_utc_date' => 'getLastExecutionUtcDate',
        'action_name' => 'getActionName',
        'report_filter_id' => 'getReportFilterId',
        'position' => 'getPosition',
        'enabled' => 'getEnabled',
        'validity_start_utc_date' => 'getValidityStartUtcDate',
        'validity_end_utc_date' => 'getValidityEndUtcDate',
        'links' => 'getLinks'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['rule_id'] = isset($data['rule_id']) ? $data['rule_id'] : null;
        $this->container['rule_name'] = isset($data['rule_name']) ? $data['rule_name'] : null;
        $this->container['last_execution_status'] = isset($data['last_execution_status']) ? $data['last_execution_status'] : null;
        $this->container['last_execution_utc_date'] = isset($data['last_execution_utc_date']) ? $data['last_execution_utc_date'] : null;
        $this->container['action_name'] = isset($data['action_name']) ? $data['action_name'] : null;
        $this->container['report_filter_id'] = isset($data['report_filter_id']) ? $data['report_filter_id'] : null;
        $this->container['position'] = isset($data['position']) ? $data['position'] : null;
        $this->container['enabled'] = isset($data['enabled']) ? $data['enabled'] : null;
        $this->container['validity_start_utc_date'] = isset($data['validity_start_utc_date']) ? $data['validity_start_utc_date'] : null;
        $this->container['validity_end_utc_date'] = isset($data['validity_end_utc_date']) ? $data['validity_end_utc_date'] : null;
        $this->container['links'] = isset($data['links']) ? $data['links'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['rule_id'] === null) {
            $invalidProperties[] = "'rule_id' can't be null";
        }
        if ($this->container['rule_name'] === null) {
            $invalidProperties[] = "'rule_name' can't be null";
        }
        if ($this->container['action_name'] === null) {
            $invalidProperties[] = "'action_name' can't be null";
        }
        if ($this->container['report_filter_id'] === null) {
            $invalidProperties[] = "'report_filter_id' can't be null";
        }
        if ($this->container['position'] === null) {
            $invalidProperties[] = "'position' can't be null";
        }
        if ($this->container['enabled'] === null) {
            $invalidProperties[] = "'enabled' can't be null";
        }
        if ($this->container['links'] === null) {
            $invalidProperties[] = "'links' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if ($this->container['rule_id'] === null) {
            return false;
        }
        if ($this->container['rule_name'] === null) {
            return false;
        }
        if ($this->container['action_name'] === null) {
            return false;
        }
        if ($this->container['report_filter_id'] === null) {
            return false;
        }
        if ($this->container['position'] === null) {
            return false;
        }
        if ($this->container['enabled'] === null) {
            return false;
        }
        if ($this->container['links'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets rule_id
     *
     * @return string
     */
    public function getRuleId()
    {
        return $this->container['rule_id'];
    }

    /**
     * Sets rule_id
     *
     * @param string $rule_id The identifier of the rule
     *
     * @return $this
     */
    public function setRuleId($rule_id)
    {
        $this->container['rule_id'] = $rule_id;

        return $this;
    }

    /**
     * Gets rule_name
     *
     * @return string
     */
    public function getRuleName()
    {
        return $this->container['rule_name'];
    }

    /**
     * Sets rule_name
     *
     * @param string $rule_name The name of the rule
     *
     * @return $this
     */
    public function setRuleName($rule_name)
    {
        $this->container['rule_name'] = $rule_name;

        return $this;
    }

    /**
     * Gets last_execution_status
     *
     * @return \Swagger\Client\Model\RuleLastExecutionStatus
     */
    public function getLastExecutionStatus()
    {
        return $this->container['last_execution_status'];
    }

    /**
     * Sets last_execution_status
     *
     * @param \Swagger\Client\Model\RuleLastExecutionStatus $last_execution_status last_execution_status
     *
     * @return $this
     */
    public function setLastExecutionStatus($last_execution_status)
    {
        $this->container['last_execution_status'] = $last_execution_status;

        return $this;
    }

    /**
     * Gets last_execution_utc_date
     *
     * @return \DateTime
     */
    public function getLastExecutionUtcDate()
    {
        return $this->container['last_execution_utc_date'];
    }

    /**
     * Sets last_execution_utc_date
     *
     * @param \DateTime $last_execution_utc_date The utc date of the last execution
     *
     * @return $this
     */
    public function setLastExecutionUtcDate($last_execution_utc_date)
    {
        $this->container['last_execution_utc_date'] = $last_execution_utc_date;

        return $this;
    }

    /**
     * Gets action_name
     *
     * @return \Swagger\Client\Model\OptimisationActionName
     */
    public function getActionName()
    {
        return $this->container['action_name'];
    }

    /**
     * Sets action_name
     *
     * @param \Swagger\Client\Model\OptimisationActionName $action_name action_name
     *
     * @return $this
     */
    public function setActionName($action_name)
    {
        $this->container['action_name'] = $action_name;

        return $this;
    }

    /**
     * Gets report_filter_id
     *
     * @return string
     */
    public function getReportFilterId()
    {
        return $this->container['report_filter_id'];
    }

    /**
     * Sets report_filter_id
     *
     * @param string $report_filter_id Report filter identifier linked to the rule
     *
     * @return $this
     */
    public function setReportFilterId($report_filter_id)
    {
        $this->container['report_filter_id'] = $report_filter_id;

        return $this;
    }

    /**
     * Gets position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->container['position'];
    }

    /**
     * Sets position
     *
     * @param int $position Rule execution position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->container['position'] = $position;

        return $this;
    }

    /**
     * Gets enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->container['enabled'];
    }

    /**
     * Sets enabled
     *
     * @param bool $enabled Is the rule enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->container['enabled'] = $enabled;

        return $this;
    }

    /**
     * Gets validity_start_utc_date
     *
     * @return \DateTime
     */
    public function getValidityStartUtcDate()
    {
        return $this->container['validity_start_utc_date'];
    }

    /**
     * Sets validity_start_utc_date
     *
     * @param \DateTime $validity_start_utc_date Rule validity start utc date
     *
     * @return $this
     */
    public function setValidityStartUtcDate($validity_start_utc_date)
    {
        $this->container['validity_start_utc_date'] = $validity_start_utc_date;

        return $this;
    }

    /**
     * Gets validity_end_utc_date
     *
     * @return \DateTime
     */
    public function getValidityEndUtcDate()
    {
        return $this->container['validity_end_utc_date'];
    }

    /**
     * Sets validity_end_utc_date
     *
     * @param \DateTime $validity_end_utc_date Rule validity end utc date
     *
     * @return $this
     */
    public function setValidityEndUtcDate($validity_end_utc_date)
    {
        $this->container['validity_end_utc_date'] = $validity_end_utc_date;

        return $this;
    }

    /**
     * Gets links
     *
     * @return \Swagger\Client\Model\RuleLinks
     */
    public function getLinks()
    {
        return $this->container['links'];
    }

    /**
     * Sets links
     *
     * @param \Swagger\Client\Model\RuleLinks $links links
     *
     * @return $this
     */
    public function setLinks($links)
    {
        $this->container['links'] = $links;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


