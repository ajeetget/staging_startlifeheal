<?php
/**
 * HarvestOrderReporting
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
 * HarvestOrderReporting Class Doc Comment
 *
 * @category Class
 * @description The reporting related to a harvest order operation
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class HarvestOrderReporting implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'harvestOrderReporting';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'execution_uuid' => '\Swagger\Client\Model\ExecutionUUID',
        'creation_utc_date' => '\DateTime',
        'processing_status' => 'string',
        'last_update_utc_date' => '\DateTime',
        'error_message' => 'string',
        'warning_message' => 'string',
        'beez_up_status' => '\Swagger\Client\Model\BeezUPOrderStatus',
        'marketplace_status' => 'string',
        'beez_up_forced_status' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'execution_uuid' => null,
        'creation_utc_date' => 'date-time',
        'processing_status' => null,
        'last_update_utc_date' => 'date-time',
        'error_message' => null,
        'warning_message' => null,
        'beez_up_status' => null,
        'marketplace_status' => null,
        'beez_up_forced_status' => null
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
        'execution_uuid' => 'executionUUID',
        'creation_utc_date' => 'creationUtcDate',
        'processing_status' => 'processingStatus',
        'last_update_utc_date' => 'lastUpdateUtcDate',
        'error_message' => 'errorMessage',
        'warning_message' => 'warningMessage',
        'beez_up_status' => 'beezUPStatus',
        'marketplace_status' => 'marketplaceStatus',
        'beez_up_forced_status' => 'beezUPForcedStatus'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'execution_uuid' => 'setExecutionUuid',
        'creation_utc_date' => 'setCreationUtcDate',
        'processing_status' => 'setProcessingStatus',
        'last_update_utc_date' => 'setLastUpdateUtcDate',
        'error_message' => 'setErrorMessage',
        'warning_message' => 'setWarningMessage',
        'beez_up_status' => 'setBeezUpStatus',
        'marketplace_status' => 'setMarketplaceStatus',
        'beez_up_forced_status' => 'setBeezUpForcedStatus'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'execution_uuid' => 'getExecutionUuid',
        'creation_utc_date' => 'getCreationUtcDate',
        'processing_status' => 'getProcessingStatus',
        'last_update_utc_date' => 'getLastUpdateUtcDate',
        'error_message' => 'getErrorMessage',
        'warning_message' => 'getWarningMessage',
        'beez_up_status' => 'getBeezUpStatus',
        'marketplace_status' => 'getMarketplaceStatus',
        'beez_up_forced_status' => 'getBeezUpForcedStatus'
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
        $this->container['execution_uuid'] = isset($data['execution_uuid']) ? $data['execution_uuid'] : null;
        $this->container['creation_utc_date'] = isset($data['creation_utc_date']) ? $data['creation_utc_date'] : null;
        $this->container['processing_status'] = isset($data['processing_status']) ? $data['processing_status'] : null;
        $this->container['last_update_utc_date'] = isset($data['last_update_utc_date']) ? $data['last_update_utc_date'] : null;
        $this->container['error_message'] = isset($data['error_message']) ? $data['error_message'] : null;
        $this->container['warning_message'] = isset($data['warning_message']) ? $data['warning_message'] : null;
        $this->container['beez_up_status'] = isset($data['beez_up_status']) ? $data['beez_up_status'] : null;
        $this->container['marketplace_status'] = isset($data['marketplace_status']) ? $data['marketplace_status'] : null;
        $this->container['beez_up_forced_status'] = isset($data['beez_up_forced_status']) ? $data['beez_up_forced_status'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

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

        return true;
    }


    /**
     * Gets execution_uuid
     *
     * @return \Swagger\Client\Model\ExecutionUUID
     */
    public function getExecutionUuid()
    {
        return $this->container['execution_uuid'];
    }

    /**
     * Sets execution_uuid
     *
     * @param \Swagger\Client\Model\ExecutionUUID $execution_uuid execution_uuid
     *
     * @return $this
     */
    public function setExecutionUuid($execution_uuid)
    {
        $this->container['execution_uuid'] = $execution_uuid;

        return $this;
    }

    /**
     * Gets creation_utc_date
     *
     * @return \DateTime
     */
    public function getCreationUtcDate()
    {
        return $this->container['creation_utc_date'];
    }

    /**
     * Sets creation_utc_date
     *
     * @param \DateTime $creation_utc_date The creation UTC date of the execution
     *
     * @return $this
     */
    public function setCreationUtcDate($creation_utc_date)
    {
        $this->container['creation_utc_date'] = $creation_utc_date;

        return $this;
    }

    /**
     * Gets processing_status
     *
     * @return string
     */
    public function getProcessingStatus()
    {
        return $this->container['processing_status'];
    }

    /**
     * Sets processing_status
     *
     * @param string $processing_status The processing status of the execution
     *
     * @return $this
     */
    public function setProcessingStatus($processing_status)
    {
        $this->container['processing_status'] = $processing_status;

        return $this;
    }

    /**
     * Gets last_update_utc_date
     *
     * @return \DateTime
     */
    public function getLastUpdateUtcDate()
    {
        return $this->container['last_update_utc_date'];
    }

    /**
     * Sets last_update_utc_date
     *
     * @param \DateTime $last_update_utc_date The last update UTC date of the execution
     *
     * @return $this
     */
    public function setLastUpdateUtcDate($last_update_utc_date)
    {
        $this->container['last_update_utc_date'] = $last_update_utc_date;

        return $this;
    }

    /**
     * Gets error_message
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->container['error_message'];
    }

    /**
     * Sets error_message
     *
     * @param string $error_message The warning message during the execution
     *
     * @return $this
     */
    public function setErrorMessage($error_message)
    {
        $this->container['error_message'] = $error_message;

        return $this;
    }

    /**
     * Gets warning_message
     *
     * @return string
     */
    public function getWarningMessage()
    {
        return $this->container['warning_message'];
    }

    /**
     * Sets warning_message
     *
     * @param string $warning_message The warning message during the execution
     *
     * @return $this
     */
    public function setWarningMessage($warning_message)
    {
        $this->container['warning_message'] = $warning_message;

        return $this;
    }

    /**
     * Gets beez_up_status
     *
     * @return \Swagger\Client\Model\BeezUPOrderStatus
     */
    public function getBeezUpStatus()
    {
        return $this->container['beez_up_status'];
    }

    /**
     * Sets beez_up_status
     *
     * @param \Swagger\Client\Model\BeezUPOrderStatus $beez_up_status beez_up_status
     *
     * @return $this
     */
    public function setBeezUpStatus($beez_up_status)
    {
        $this->container['beez_up_status'] = $beez_up_status;

        return $this;
    }

    /**
     * Gets marketplace_status
     *
     * @return string
     */
    public function getMarketplaceStatus()
    {
        return $this->container['marketplace_status'];
    }

    /**
     * Sets marketplace_status
     *
     * @param string $marketplace_status The order marketplace status
     *
     * @return $this
     */
    public function setMarketplaceStatus($marketplace_status)
    {
        $this->container['marketplace_status'] = $marketplace_status;

        return $this;
    }

    /**
     * Gets beez_up_forced_status
     *
     * @return string
     */
    public function getBeezUpForcedStatus()
    {
        return $this->container['beez_up_forced_status'];
    }

    /**
     * Sets beez_up_forced_status
     *
     * @param string $beez_up_forced_status The marketplace order status forced by BeezUP during the order change oepration. This could happend when there is no status on the marketplace side.
     *
     * @return $this
     */
    public function setBeezUpForcedStatus($beez_up_forced_status)
    {
        $this->container['beez_up_forced_status'] = $beez_up_forced_status;

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

