<?php
/**
 * AutoImportConfiguration
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
 * AutoImportConfiguration Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class AutoImportConfiguration implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'autoImportConfiguration';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'input' => '\Swagger\Client\Model\InputConfiguration',
        'input_configured_by_user_id' => '\Swagger\Client\Model\BeezUPCommonUserId',
        'scheduling_type' => '\Swagger\Client\Model\SchedulingType',
        'scheduled_by_user_id' => '\Swagger\Client\Model\BeezUPCommonUserId',
        'scheduling_value' => 'string[]',
        'paused' => 'bool',
        'pause_status_changed_by_user_id' => '\Swagger\Client\Model\BeezUPCommonUserId',
        'pause_status_changed_utc_date' => '\DateTime',
        'duplicate_product_configuration' => '\Swagger\Client\Model\DuplicateProductValueConfiguration',
        'scheduling_local_time_zone_name' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'input' => null,
        'input_configured_by_user_id' => null,
        'scheduling_type' => null,
        'scheduled_by_user_id' => null,
        'scheduling_value' => null,
        'paused' => null,
        'pause_status_changed_by_user_id' => null,
        'pause_status_changed_utc_date' => 'date-time',
        'duplicate_product_configuration' => null,
        'scheduling_local_time_zone_name' => null
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
        'input' => 'input',
        'input_configured_by_user_id' => 'inputConfiguredByUserId',
        'scheduling_type' => 'schedulingType',
        'scheduled_by_user_id' => 'scheduledByUserId',
        'scheduling_value' => 'schedulingValue',
        'paused' => 'paused',
        'pause_status_changed_by_user_id' => 'pauseStatusChangedByUserId',
        'pause_status_changed_utc_date' => 'pauseStatusChangedUtcDate',
        'duplicate_product_configuration' => 'duplicateProductConfiguration',
        'scheduling_local_time_zone_name' => 'schedulingLocalTimeZoneName'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'input' => 'setInput',
        'input_configured_by_user_id' => 'setInputConfiguredByUserId',
        'scheduling_type' => 'setSchedulingType',
        'scheduled_by_user_id' => 'setScheduledByUserId',
        'scheduling_value' => 'setSchedulingValue',
        'paused' => 'setPaused',
        'pause_status_changed_by_user_id' => 'setPauseStatusChangedByUserId',
        'pause_status_changed_utc_date' => 'setPauseStatusChangedUtcDate',
        'duplicate_product_configuration' => 'setDuplicateProductConfiguration',
        'scheduling_local_time_zone_name' => 'setSchedulingLocalTimeZoneName'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'input' => 'getInput',
        'input_configured_by_user_id' => 'getInputConfiguredByUserId',
        'scheduling_type' => 'getSchedulingType',
        'scheduled_by_user_id' => 'getScheduledByUserId',
        'scheduling_value' => 'getSchedulingValue',
        'paused' => 'getPaused',
        'pause_status_changed_by_user_id' => 'getPauseStatusChangedByUserId',
        'pause_status_changed_utc_date' => 'getPauseStatusChangedUtcDate',
        'duplicate_product_configuration' => 'getDuplicateProductConfiguration',
        'scheduling_local_time_zone_name' => 'getSchedulingLocalTimeZoneName'
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
        $this->container['input'] = isset($data['input']) ? $data['input'] : null;
        $this->container['input_configured_by_user_id'] = isset($data['input_configured_by_user_id']) ? $data['input_configured_by_user_id'] : null;
        $this->container['scheduling_type'] = isset($data['scheduling_type']) ? $data['scheduling_type'] : null;
        $this->container['scheduled_by_user_id'] = isset($data['scheduled_by_user_id']) ? $data['scheduled_by_user_id'] : null;
        $this->container['scheduling_value'] = isset($data['scheduling_value']) ? $data['scheduling_value'] : null;
        $this->container['paused'] = isset($data['paused']) ? $data['paused'] : false;
        $this->container['pause_status_changed_by_user_id'] = isset($data['pause_status_changed_by_user_id']) ? $data['pause_status_changed_by_user_id'] : null;
        $this->container['pause_status_changed_utc_date'] = isset($data['pause_status_changed_utc_date']) ? $data['pause_status_changed_utc_date'] : null;
        $this->container['duplicate_product_configuration'] = isset($data['duplicate_product_configuration']) ? $data['duplicate_product_configuration'] : null;
        $this->container['scheduling_local_time_zone_name'] = isset($data['scheduling_local_time_zone_name']) ? $data['scheduling_local_time_zone_name'] : 'Romance Standard Time';
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['input'] === null) {
            $invalidProperties[] = "'input' can't be null";
        }
        if ($this->container['input_configured_by_user_id'] === null) {
            $invalidProperties[] = "'input_configured_by_user_id' can't be null";
        }
        if ($this->container['scheduling_type'] === null) {
            $invalidProperties[] = "'scheduling_type' can't be null";
        }
        if ($this->container['scheduling_value'] === null) {
            $invalidProperties[] = "'scheduling_value' can't be null";
        }
        if ($this->container['paused'] === null) {
            $invalidProperties[] = "'paused' can't be null";
        }
        if ($this->container['duplicate_product_configuration'] === null) {
            $invalidProperties[] = "'duplicate_product_configuration' can't be null";
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

        if ($this->container['input'] === null) {
            return false;
        }
        if ($this->container['input_configured_by_user_id'] === null) {
            return false;
        }
        if ($this->container['scheduling_type'] === null) {
            return false;
        }
        if ($this->container['scheduling_value'] === null) {
            return false;
        }
        if ($this->container['paused'] === null) {
            return false;
        }
        if ($this->container['duplicate_product_configuration'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets input
     *
     * @return \Swagger\Client\Model\InputConfiguration
     */
    public function getInput()
    {
        return $this->container['input'];
    }

    /**
     * Sets input
     *
     * @param \Swagger\Client\Model\InputConfiguration $input input
     *
     * @return $this
     */
    public function setInput($input)
    {
        $this->container['input'] = $input;

        return $this;
    }

    /**
     * Gets input_configured_by_user_id
     *
     * @return \Swagger\Client\Model\BeezUPCommonUserId
     */
    public function getInputConfiguredByUserId()
    {
        return $this->container['input_configured_by_user_id'];
    }

    /**
     * Sets input_configured_by_user_id
     *
     * @param \Swagger\Client\Model\BeezUPCommonUserId $input_configured_by_user_id input_configured_by_user_id
     *
     * @return $this
     */
    public function setInputConfiguredByUserId($input_configured_by_user_id)
    {
        $this->container['input_configured_by_user_id'] = $input_configured_by_user_id;

        return $this;
    }

    /**
     * Gets scheduling_type
     *
     * @return \Swagger\Client\Model\SchedulingType
     */
    public function getSchedulingType()
    {
        return $this->container['scheduling_type'];
    }

    /**
     * Sets scheduling_type
     *
     * @param \Swagger\Client\Model\SchedulingType $scheduling_type scheduling_type
     *
     * @return $this
     */
    public function setSchedulingType($scheduling_type)
    {
        $this->container['scheduling_type'] = $scheduling_type;

        return $this;
    }

    /**
     * Gets scheduled_by_user_id
     *
     * @return \Swagger\Client\Model\BeezUPCommonUserId
     */
    public function getScheduledByUserId()
    {
        return $this->container['scheduled_by_user_id'];
    }

    /**
     * Sets scheduled_by_user_id
     *
     * @param \Swagger\Client\Model\BeezUPCommonUserId $scheduled_by_user_id scheduled_by_user_id
     *
     * @return $this
     */
    public function setScheduledByUserId($scheduled_by_user_id)
    {
        $this->container['scheduled_by_user_id'] = $scheduled_by_user_id;

        return $this;
    }

    /**
     * Gets scheduling_value
     *
     * @return string[]
     */
    public function getSchedulingValue()
    {
        return $this->container['scheduling_value'];
    }

    /**
     * Sets scheduling_value
     *
     * @param string[] $scheduling_value Indicate the scheduling value. If the scheduling type is Interval then the value will be a duration otherwise the values will be the time.
     *
     * @return $this
     */
    public function setSchedulingValue($scheduling_value)
    {
        $this->container['scheduling_value'] = $scheduling_value;

        return $this;
    }

    /**
     * Gets paused
     *
     * @return bool
     */
    public function getPaused()
    {
        return $this->container['paused'];
    }

    /**
     * Sets paused
     *
     * @param bool $paused Indicate if the auto import is in pause or not.
     *
     * @return $this
     */
    public function setPaused($paused)
    {
        $this->container['paused'] = $paused;

        return $this;
    }

    /**
     * Gets pause_status_changed_by_user_id
     *
     * @return \Swagger\Client\Model\BeezUPCommonUserId
     */
    public function getPauseStatusChangedByUserId()
    {
        return $this->container['pause_status_changed_by_user_id'];
    }

    /**
     * Sets pause_status_changed_by_user_id
     *
     * @param \Swagger\Client\Model\BeezUPCommonUserId $pause_status_changed_by_user_id pause_status_changed_by_user_id
     *
     * @return $this
     */
    public function setPauseStatusChangedByUserId($pause_status_changed_by_user_id)
    {
        $this->container['pause_status_changed_by_user_id'] = $pause_status_changed_by_user_id;

        return $this;
    }

    /**
     * Gets pause_status_changed_utc_date
     *
     * @return \DateTime
     */
    public function getPauseStatusChangedUtcDate()
    {
        return $this->container['pause_status_changed_utc_date'];
    }

    /**
     * Sets pause_status_changed_utc_date
     *
     * @param \DateTime $pause_status_changed_utc_date Indicate when the pause status has changed in UTC date.
     *
     * @return $this
     */
    public function setPauseStatusChangedUtcDate($pause_status_changed_utc_date)
    {
        $this->container['pause_status_changed_utc_date'] = $pause_status_changed_utc_date;

        return $this;
    }

    /**
     * Gets duplicate_product_configuration
     *
     * @return \Swagger\Client\Model\DuplicateProductValueConfiguration
     */
    public function getDuplicateProductConfiguration()
    {
        return $this->container['duplicate_product_configuration'];
    }

    /**
     * Sets duplicate_product_configuration
     *
     * @param \Swagger\Client\Model\DuplicateProductValueConfiguration $duplicate_product_configuration duplicate_product_configuration
     *
     * @return $this
     */
    public function setDuplicateProductConfiguration($duplicate_product_configuration)
    {
        $this->container['duplicate_product_configuration'] = $duplicate_product_configuration;

        return $this;
    }

    /**
     * Gets scheduling_local_time_zone_name
     *
     * @return string
     */
    public function getSchedulingLocalTimeZoneName()
    {
        return $this->container['scheduling_local_time_zone_name'];
    }

    /**
     * Sets scheduling_local_time_zone_name
     *
     * @param string $scheduling_local_time_zone_name Indicate the time zone name of the scheduling. If the scheduling type is \"Schedule\"
     *
     * @return $this
     */
    public function setSchedulingLocalTimeZoneName($scheduling_local_time_zone_name)
    {
        $this->container['scheduling_local_time_zone_name'] = $scheduling_local_time_zone_name;

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


