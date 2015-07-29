<?php
 
namespace Dandelionapi\apis;
 
use GuzzleHttp\Client;

class EntityExtraction extends DandelionBase
{

    use CommonFuntions;

    const END_POINT = "https://api.dandelion.eu/datatxt/nex/v1";

    private static $_dollarPrefix =[
        'app_key'=> '$app_key',
        'app_id' => '$app_id',
    ];

    /**
     * @var string
     * These parameters define how you send text to the Entity Extraction API. Only one of them can be used in each
     * request, following these guidelines:
     * use "text" when you have plain text that doesn't need any pre-processing;
     */
    protected $_text;

    /**
     * These parameters define how you send text to the Entity Extraction API. Only one of them can be used in each
     * request, following these guidelines:
     * @var
     *
     * use "url" when you have an URL and you want the Entity Extraction API to work on its main content; it will fetch the URL for you, and use an AI algorithm to extract the relevant part of the document to work on; in this case, the main content will also be returned by the API to allow you to properly use the annotation offsets;
     */
    protected $_url;

    /**
     * These parameters define how you send text to the Entity Extraction API. Only one of them can be used in each
     * request, following these guidelines:
     * @var
     *
     * use "html" when you have an HTML document and you want the Entity Extraction API to work on its main content, similarly to what the "url" parameter does.
     */
    protected $_html;

    /**
     * These parameters define how you send text to the Entity Extraction API. Only one of them can be used in each
     * request, following these guidelines:
     * @var
     *
     * use "html_fragment" when you have an HTML snippet and you want the Entity Extraction API to work on its content. It will remove all HTML tags before analyzing it.
     */
    protected $_htmlFragment;

    /**
     * The language of the text to be annotated; currently English, French, German, Italian and Portuguese are supported. Leave this parameter out to let the Entity Extraction API automatically detect the language for you.
     * @var
     * lang optional
     * Type	string
     * Default value	auto
     * Accepted values	de | en | fr | it | pt | auto
     */
    protected $_lang; // = "auto";


    /**
     * The threshold for the confidence value; entities with a confidence value below this threshold will be discarded. Confidence is a numeric estimation of the quality of the annotation, which ranges between 0 and 1. A higher threshold means you will get less but more precise annotations. A lower value means you will get more annotations but also more erroneous ones.
     * @var
     * min_confidence optional
     * Type	float
     * Default value	0.6
     * Accepted values	0.0 .. 1.0
     */
    protected $_minConfidence; // = "0.6";

    /**
     * min_length optional
     * With this parameter you can remove those entities having a spot shorter than a minimum length.
     * Type	integer
     * Default value	2
     * Accepted values	2 .. +inf
     * @var
     */
    protected $_minLength; // = "2";

    /**
     * parse_hashtag renamed optional
     * Use social.hashtag instead.
     * social.hashtag optional
     * With this parameter you enable special hashtag parsing to correctly analyze tweets and facebook posts.
     * Type	boolean
     * Default value	false
     * Accepted values	true | false
     * @var
     */
    protected $_parseHashtag; // = "false";

    /**
     * social.mention optional
     * With this parameter you enable special mention parsing to correctly analyze tweets and facebook posts.
     * Type	boolean
     * Default value	false
     * Accepted values	true | false
     * @var
     */
    protected $_socialMention; // = "false";

    /**
     * include optional
     * Returns more information on annotated entities:
     * "types" adds type information from DBpedia or dandelion. DBpedia types are extracted based on the lang parameter (e.g. if lang=en, types are extracted from DBpedia english). Please notice that different DBpedia instances may contain different types for the same resource;
     * "categories" adds category information from DBpedia/Wikipedia;
     * "abstract" adds the text of the Wikipedia abstract;
     * "image" adds a link to an image depicting the tagged entity, as well as a link to the image thumbnail, served by Wikipedia. Please check the licensing terms of each image on Wikipedia before using it in your app;
     * "lod" adds links to equivalent (sameAs) entities in Linked Open Data repositories or other websites. It currently only supports DBpedia and Wikipedia;
     * "alternate_labels" adds some other names used when referring to the entity.
     * Type	comma-separated list
     * Default value	<empty string>
     * Accepted values	types, categories, abstract, image, lod, alternate_labels
     * Example	include=types,lod
     * @var
     */
    protected $_include; // = "";

    /**
     * extra_types optional
     * Returns more information on annotated entities:
     * "phone" enables matching of phone numbers;
     * "vat" enables matching of VAT IDs (Italian only).
     * Note that these parameters require the country parameter to be set, and VAT IDs will work only for Italy.
     * Type	comma-separated list
     * Default value	<empty string>
     * Accepted values	phone, vat
     * Example	extra_types=phone,vat
     * @var
     */
    protected $_extraTypes; // = "";

    /**
     * country optional
     * This parameter specifies the country which we assume VAT and telephone numbers to be coming from. This is important to get correct results, as different countries may adopt different formats.
     * Type	string
     * Default value	<empty string>
     * Accepted values	AD, AE, AM, AO, AQ, AR, AU, BB, BR, BS, BY, CA, CH, CL, CN, CX, DE, FR, GB, HU, IT, JP, KR, MX, NZ, PG, PL, RE, SE, SG, US, YT, ZW
     * @var
     */
    protected $_country; // = "";

    /**
     * custom_spots optional
     * Enable specific user-defined spots to be used when annotating the text. You can define your own spots or use someone else's ones if they shared the spots-ID with you.
     * Type	string
     * Default value	<empty string>
     * Accepted values	any valid spots-ID
     * @var
     */
    protected $_customSpots; // = "";


    /**
     * @var float epsilon optional advanced
     * This parameter defines whether the Entity Extraction API should rely more on the context or favor more common topics to discover entities. Using an higher value favors more common topics, this may lead to better results when processing tweets or other fragmented inputs where the context is not always reliable.
     * Default value	0.3
     * Accepted values	0.0 .. 0.5
     */
    protected $_epsilon; // = "0.3";


    /**
     * Create a new EntityExtraction Instance
     */
    public function __construct($params=[])
    {
        $this->_populate($params);
    }


    public function callText()
    {
        if($this->hasText()==false){
            throw new \Exception("Missing text");
        }

        $_params=[];
        $_props=$this->readProperties();
        foreach($_props as $_k => $_v){
            $_index = $this->deCamelize($_v->name);
            $_func = ucfirst( ltrim($_v->name,'_'));
            $_getter = "get{$_func}";
            $_haver = "has{$_func}";
            if($this->$_haver() == false){
                continue;
            }
            if(isset(static::$_dollarPrefix[$_index])) {
                $_params[static::$_dollarPrefix[$_index]] = $this->$_getter();
            } else {
                $_params[$_index] = $this->$_getter();
            }
        }

        try{
        $client = new Client();
        $res = $client->get(static::END_POINT,
            [
                'query' =>  $_params,
                'timeout' => '60',
            ]
        );
        $_sc = $res->getStatusCode();

        if($_sc < 200 || $_sc>=300  ){
            throw new \Exception("error");
        }
        $_rv = $res->getBody();
        } catch(\Exception $e){
            throw $e;
        }
        return $_rv;
    }


    /************************************************************/

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * @return bool
     */
    public function hasText()
    {
        return isset($this->_text);
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return bool
     */
    public function hasUrl()
    {
        return isset($this->_url);
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->_html;
    }

    /**
     * @return bool
     */
    public function hasHtml()
    {
        return isset($this->_html);
    }

    /**
     * @param mixed $html
     */
    public function setHtml($html)
    {
        $this->_html = $html;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHtmlFragment()
    {
        return $this->_htmlFragment;
    }

    /**
     * @return bool
     */
    public function hasHtmlFragment()
    {
        return isset($this->_htmlFragment);
    }

    /**
     * @param mixed $htmlFragment
     */
    public function setHtmlFragment($htmlFragment)
    {
        $this->_htmlFragment = $htmlFragment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->_lang;
    }

    /**
     * @return bool
     */
    public function hasLang()
    {
        return isset($this->_lang);
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang)
    {
        $this->_lang = $lang;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinConfidence()
    {
        return $this->_minConfidence;
    }

    /**
     * @return bool
     */
    public function hasMinConfidence()
    {
        return isset($this->_minConfidence);
    }

    /**
     * @param mixed $minConfidence
     */
    public function setMinConfidence($minConfidence)
    {
        $this->_minConfidence = $minConfidence;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinLength()
    {
        return $this->_minLength;
    }

    /**
     * @return bool
     */
    public function hasMinLength()
    {
        return isset($this->_minLength);
    }

    /**
     * @param mixed $minLength
     */
    public function setMinLength($minLength)
    {
        $this->_minLength = $minLength;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParseHashtag()
    {
        return $this->_parseHashtag;
    }

    /**
     * @return bool
     */
    public function hasParseHashtag()
    {
        return isset($this->_parseHashtag);
    }

    /**
     * @param mixed $parseHashtag
     */
    public function setParseHashtag($parseHashtag)
    {
        $this->_parseHashtag = $parseHashtag;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSocialMention()
    {
        return $this->_socialMention;
    }

    /**
     * @return bool
     */
    public function hasSocialMention()
    {
        return isset($this->_socialMention);
    }

    /**
     * @param mixed $socialMention
     */
    public function setSocialMention($socialMention)
    {
        $this->_socialMention = $socialMention;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInclude()
    {
        return $this->_include;
    }

    /**
     * @return bool
     */
    public function hasInclude()
    {
        return isset($this->_include);
    }

    /**
     * @param mixed $include
     */
    public function setInclude($include)
    {
        $this->_include = $include;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtraTypes()
    {
        return $this->_extraTypes;
    }

    /**
     * @return bool
     */
    public function hasExtraTypes()
    {
        return isset($this->_extraTypes);
    }

    /**
     * @param mixed $extraTypes
     */
    public function setExtraTypes($extraTypes)
    {
        $this->_extraTypes = $extraTypes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * @return bool
     */
    public function hasCountry()
    {
        return isset($this->_country);
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->_country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomSpots()
    {
        return $this->_customSpots;
    }

    /**
     * @return bool
     */
    public function hasCustomSpots()
    {
        return isset($this->_customSpots);
    }

    /**
     * @param mixed $customSpots
     */
    public function setCustomSpots($customSpots)
    {
        $this->_customSpots = $customSpots;
        return $this;
    }

    /**
     * @return float
     */
    public function getEpsilon()
    {
        return $this->_epsilon;
    }

    /**
     * @return bool
     */
    public function hasEpsilon()
    {
        return isset($this->_epsilon);
    }

    /**
     * @param float $epsilon
     */
    public function setEpsilon($epsilon)
    {
        $this->_epsilon = $epsilon;
        return $this;
    }







}