<?php
/**
 * ChannelCatalogColumnMappingWithName
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
 * ChannelCatalogColumnMappingWithName Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ChannelCatalogColumnMappingWithName implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'channelCatalogColumnMappingWithName';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'channel_column_id' => '\Swagger\Client\Model\BeezUPCommonChannelColumnId',
        'channel_category_path' => '\Swagger\Client\Model\BeezUPCommonChannelCategoryPath',
        'catalog_column_id' => '\Swagger\Client\Model\BeezUPCommonCatalogColumnId',
        'channel_column_name' => '\Swagger\Client\Model\BeezUPCommonChannelColumnName',
        'channel_beez_up_column_name' => '\Swagger\Client\Model\BeezUPCommonBeezUPColumnName',
        'catalog_column_name' => '\Swagger\Client\Model\BeezUPCommonCatalogColumnUserName',
        'catalog_beez_up_column_name' => '\Swagger\Client\Model\BeezUPCommonBeezUPColumnName'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'channel_column_id' => null,
        'channel_category_path' => null,
        'catalog_column_id' => null,
        'channel_column_name' => null,
        'channel_beez_up_column_name' => null,
        'catalog_column_name' => null,
        'catalog_beez_up_column_name' => null
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
        'channel_column_id' => 'channelColumnId',
        'channel_category_path' => 'channelCategoryPath',
        'catalog_column_id' => 'catalogColumnId',
        'channel_column_name' => 'channelColumnName',
        'channel_beez_up_column_name' => 'channelBeezUPColumnName',
        'catalog_column_name' => 'catalogColumnName',
        'catalog_beez_up_column_name' => 'catalogBeezUPColumnName'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'channel_column_id' => 'setChannelColumnId',
        'channel_category_path' => 'setChannelCategoryPath',
        'catalog_column_id' => 'setCatalogColumnId',
        'channel_column_name' => 'setChannelColumnName',
        'channel_beez_up_column_name' => 'setChannelBeezUpColumnName',
        'catalog_column_name' => 'setCatalogColumnName',
        'catalog_beez_up_column_name' => 'setCatalogBeezUpColumnName'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'channel_column_id' => 'getChannelColumnId',
        'channel_category_path' => 'getChannelCategoryPath',
        'catalog_column_id' => 'getCatalogColumnId',
        'channel_column_name' => 'getChannelColumnName',
        'channel_beez_up_column_name' => 'getChannelBeezUpColumnName',
        'catalog_column_name' => 'getCatalogColumnName',
        'catalog_beez_up_column_name' => 'getCatalogBeezUpColumnName'
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
        $this->container['channel_column_id'] = isset($data['channel_column_id']) ? $data['channel_column_id'] : null;
        $this->container['channel_category_path'] = isset($data['channel_category_path']) ? $data['channel_category_path'] : null;
        $this->container['catalog_column_id'] = isset($data['catalog_column_id']) ? $data['catalog_column_id'] : null;
        $this->container['channel_column_name'] = isset($data['channel_column_name']) ? $data['channel_column_name'] : null;
        $this->container['channel_beez_up_column_name'] = isset($data['channel_beez_up_column_name']) ? $data['channel_beez_up_column_name'] : null;
        $this->container['catalog_column_name'] = isset($data['catalog_column_name']) ? $data['catalog_column_name'] : null;
        $this->container['catalog_beez_up_column_name'] = isset($data['catalog_beez_up_column_name']) ? $data['catalog_beez_up_column_name'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['channel_column_id'] === null) {
            $invalidProperties[] = "'channel_column_id' can't be null";
        }
        if ($this->container['channel_column_name'] === null) {
            $invalidProperties[] = "'channel_column_name' can't be null";
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

        if ($this->container['channel_column_id'] === null) {
            return false;
        }
        if ($this->container['channel_column_name'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets channel_column_id
     *
     * @return \Swagger\Client\Model\BeezUPCommonChannelColumnId
     */
    public function getChannelColumnId()
    {
        return $this->container['channel_column_id'];
    }

    /**
     * Sets channel_column_id
     *
     * @param \Swagger\Client\Model\BeezUPCommonChannelColumnId $channel_column_id channel_column_id
     *
     * @return $this
     */
    public function setChannelColumnId($channel_column_id)
    {
        $this->container['channel_column_id'] = $channel_column_id;

        return $this;
    }

    /**
     * Gets channel_category_path
     *
     * @return \Swagger\Client\Model\BeezUPCommonChannelCategoryPath
     */
    public function getChannelCategoryPath()
    {
        return $this->container['channel_category_path'];
    }

    /**
     * Sets channel_category_path
     *
     * @param \Swagger\Client\Model\BeezUPCommonChannelCategoryPath $channel_category_path channel_category_path
     *
     * @return $this
     */
    public function setChannelCategoryPath($channel_category_path)
    {
        $this->container['channel_category_path'] = $channel_category_path;

        return $this;
    }

    /**
     * Gets catalog_column_id
     *
     * @return \Swagger\Client\Model\BeezUPCommonCatalogColumnId
     */
    public function getCatalogColumnId()
    {
        return $this->container['catalog_column_id'];
    }

    /**
     * Sets catalog_column_id
     *
     * @param \Swagger\Client\Model\BeezUPCommonCatalogColumnId $catalog_column_id catalog_column_id
     *
     * @return $this
     */
    public function setCatalogColumnId($catalog_column_id)
    {
        $this->container['catalog_column_id'] = $catalog_column_id;

        return $this;
    }

    /**
     * Gets channel_column_name
     *
     * @return \Swagger\Client\Model\BeezUPCommonChannelColumnName
     */
    public function getChannelColumnName()
    {
        return $this->container['channel_column_name'];
    }

    /**
     * Sets channel_column_name
     *
     * @param \Swagger\Client\Model\BeezUPCommonChannelColumnName $channel_column_name channel_column_name
     *
     * @return $this
     */
    public function setChannelColumnName($channel_column_name)
    {
        $this->container['channel_column_name'] = $channel_column_name;

        return $this;
    }

    /**
     * Gets channel_beez_up_column_name
     *
     * @return \Swagger\Client\Model\BeezUPCommonBeezUPColumnName
     */
    public function getChannelBeezUpColumnName()
    {
        return $this->container['channel_beez_up_column_name'];
    }

    /**
     * Sets channel_beez_up_column_name
     *
     * @param \Swagger\Client\Model\BeezUPCommonBeezUPColumnName $channel_beez_up_column_name channel_beez_up_column_name
     *
     * @return $this
     */
    public function setChannelBeezUpColumnName($channel_beez_up_column_name)
    {
        $this->container['channel_beez_up_column_name'] = $channel_beez_up_column_name;

        return $this;
    }

    /**
     * Gets catalog_column_name
     *
     * @return \Swagger\Client\Model\BeezUPCommonCatalogColumnUserName
     */
    public function getCatalogColumnName()
    {
        return $this->container['catalog_column_name'];
    }

    /**
     * Sets catalog_column_name
     *
     * @param \Swagger\Client\Model\BeezUPCommonCatalogColumnUserName $catalog_column_name catalog_column_name
     *
     * @return $this
     */
    public function setCatalogColumnName($catalog_column_name)
    {
        $this->container['catalog_column_name'] = $catalog_column_name;

        return $this;
    }

    /**
     * Gets catalog_beez_up_column_name
     *
     * @return \Swagger\Client\Model\BeezUPCommonBeezUPColumnName
     */
    public function getCatalogBeezUpColumnName()
    {
        return $this->container['catalog_beez_up_column_name'];
    }

    /**
     * Sets catalog_beez_up_column_name
     *
     * @param \Swagger\Client\Model\BeezUPCommonBeezUPColumnName $catalog_beez_up_column_name catalog_beez_up_column_name
     *
     * @return $this
     */
    public function setCatalogBeezUpColumnName($catalog_beez_up_column_name)
    {
        $this->container['catalog_beez_up_column_name'] = $catalog_beez_up_column_name;

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


