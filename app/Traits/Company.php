<?php
namespace App\Traits;

/**
 * (no documentation provided)
 */
class Company
{

    /**
     * unique company identification id
     *
     * @var integer
     */
    private $company_id;

    /**
     * name of the company
     *
     * @var string
     */
    private $company_name;

    /**
     * the company contact person
     *
     * @var string
     */
    private $contact_person;

    /**
     * currencyType defining the native currency of the company (all prices, sums will be handled in this currency type)
     *
     * @var string
     */
    private $native_currency;

    /**
     * street address of the company
     *
     * @var string
     */
    private $address;

    /**
     * Postal code for the company
     *
     * @var string
     */
    private $zip_code;

    /**
     * City/location address for the company
     *
     * @var string
     */
    private $city;

    /**
     * iso_3166 numeric country code of which visbook location the visbook customer belongs to,
     * f.ex if a hotel in Spain is a customer registered with VisBook AS in Norway, this code will be 578 (code for Norway),
     * please see &lt;i&gt;company_country_code&lt;/i&gt; to get the actual country where the company exists in
     *
     * @var integer
     */
    private $country_code;

    /**
     * main phone number
     *
     * @var string
     */
    private $phone;

    /**
     * fax number
     *
     * @var string
     */
    private $fax;

    /**
     * official email address for the company
     *
     * @var string
     */
    private $email;

    /**
     * language type of the company
     *
     * @var string
     */
    private $native_language;

    /**
     * homepage for the company
     *
     * @var string
     */
    private $web_address;

    /**
     * VAT code for the company
     *
     * @var string
     */
    private $vat_code;

    /**
     * list of attributes specific to the company
     *
     * @var \App\Traits\Attribute[]
     */
    private $attributes;

    /**
     * Customer ID in VisBook
     *
     * @var integer
     */
    private $visbook_customer_id;

    /**
     * &lt;p&gt;iso_3166 numeric country code where the company actually exists (can be different than country_code)
     * f.ex if a hotel in Spain is a customer registered with VisBook AS in Norway, this code will be 724 (code for Spain)&lt;/p&gt;
     * &lt;p&gt;to get the country code for which visbook location this company belongs to, please see &lt;i&gt;country_code&lt;/i&gt;&lt;/p&gt;
     *
     * @var integer
     */
    private $company_country_code;

    /**
     * timezone
     *
     *
     * https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
     *
     * @var string
     */
    private $timezone;

    /**
     * Constructs a Company from an XMLReader
     *
     * @param \XMLReader $reader The reader.
     */
    public function __construct($reader = null)
    {
        $success = true;
        while ($success && $reader->nodeType != \XMLReader::ELEMENT) {
            $success = $reader->read();
        }
        if ($reader->nodeType != \XMLReader::ELEMENT) {
            throw new \Exception("Unable to read XML: no start element found.");
        }

        $this->initFromReader($reader);
    }

    /**
     * unique company identification id
     *
     * @return integer
     */
    public function getCompany_id()
    {
        return $this->company_id;
    }

    /**
     * unique company identification id
     *
     * @param integer $company_id
     */
    public function setCompany_id($company_id)
    {
        $this->company_id = $company_id;
    }
    /**
     * name of the company
     *
     * @return string
     */
    public function getCompany_name()
    {
        return $this->company_name;
    }

    /**
     * name of the company
     *
     * @param string $company_name
     */
    public function setCompany_name($company_name)
    {
        $this->company_name = $company_name;
    }
    /**
     * the company contact person
     *
     * @return string
     */
    public function getContact_person()
    {
        return $this->contact_person;
    }

    /**
     * the company contact person
     *
     * @param string $contact_person
     */
    public function setContact_person($contact_person)
    {
        $this->contact_person = $contact_person;
    }
    /**
     * currencyType defining the native currency of the company (all prices, sums will be handled in this currency type)
     *
     * @return string
     */
    public function getNative_currency()
    {
        return $this->native_currency;
    }

    /**
     * currencyType defining the native currency of the company (all prices, sums will be handled in this currency type)
     *
     * @param string $native_currency
     */
    public function setNative_currency($native_currency)
    {
        $this->native_currency = $native_currency;
    }
    /**
     * street address of the company
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * street address of the company
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    /**
     * Postal code for the company
     *
     * @return string
     */
    public function getZip_code()
    {
        return $this->zip_code;
    }

    /**
     * Postal code for the company
     *
     * @param string $zip_code
     */
    public function setZip_code($zip_code)
    {
        $this->zip_code = $zip_code;
    }
    /**
     * City/location address for the company
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * City/location address for the company
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
    /**
     * iso_3166 numeric country code of which visbook location the visbook customer belongs to,
     * f.ex if a hotel in Spain is a customer registered with VisBook AS in Norway, this code will be 578 (code for Norway),
     * please see &lt;i&gt;company_country_code&lt;/i&gt; to get the actual country where the company exists in
     *
     * @return integer
     */
    public function getCountry_code()
    {
        return $this->country_code;
    }

    /**
     * iso_3166 numeric country code of which visbook location the visbook customer belongs to,
     * f.ex if a hotel in Spain is a customer registered with VisBook AS in Norway, this code will be 578 (code for Norway),
     * please see &lt;i&gt;company_country_code&lt;/i&gt; to get the actual country where the company exists in
     *
     * @param integer $country_code
     */
    public function setCountry_code($country_code)
    {
        $this->country_code = $country_code;
    }
    /**
     * main phone number
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * main phone number
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    /**
     * fax number
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * fax number
     *
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }
    /**
     * official email address for the company
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * official email address for the company
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * language type of the company
     *
     * @return string
     */
    public function getNative_language()
    {
        return $this->native_language;
    }

    /**
     * language type of the company
     *
     * @param string $native_language
     */
    public function setNative_language($native_language)
    {
        $this->native_language = $native_language;
    }
    /**
     * homepage for the company
     *
     * @return string
     */
    public function getWeb_address()
    {
        return $this->web_address;
    }

    /**
     * homepage for the company
     *
     * @param string $web_address
     */
    public function setWeb_address($web_address)
    {
        $this->web_address = $web_address;
    }
    /**
     * VAT code for the company
     *
     * @return string
     */
    public function getVat_code()
    {
        return $this->vat_code;
    }

    /**
     * VAT code for the company
     *
     * @param string $vat_code
     */
    public function setVat_code($vat_code)
    {
        $this->vat_code = $vat_code;
    }
    /**
     * list of attributes specific to the company
     *
     * @return \App\Traits\Attribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * list of attributes specific to the company
     *
     * @param \App\Traits\Attribute[] $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }
    /**
     * Customer ID in VisBook
     *
     * @return integer
     */
    public function getVisbook_customer_id()
    {
        return $this->visbook_customer_id;
    }

    /**
     * Customer ID in VisBook
     *
     * @param integer $visbook_customer_id
     */
    public function setVisbook_customer_id($visbook_customer_id)
    {
        $this->visbook_customer_id = $visbook_customer_id;
    }
    /**
     * &lt;p&gt;iso_3166 numeric country code where the company actually exists (can be different than country_code)
     * f.ex if a hotel in Spain is a customer registered with VisBook AS in Norway, this code will be 724 (code for Spain)&lt;/p&gt;
     * &lt;p&gt;to get the country code for which visbook location this company belongs to, please see &lt;i&gt;country_code&lt;/i&gt;&lt;/p&gt;
     *
     * @return integer
     */
    public function getCompany_country_code()
    {
        return $this->company_country_code;
    }

    /**
     * &lt;p&gt;iso_3166 numeric country code where the company actually exists (can be different than country_code)
     * f.ex if a hotel in Spain is a customer registered with VisBook AS in Norway, this code will be 724 (code for Spain)&lt;/p&gt;
     * &lt;p&gt;to get the country code for which visbook location this company belongs to, please see &lt;i&gt;country_code&lt;/i&gt;&lt;/p&gt;
     *
     * @param integer $company_country_code
     */
    public function setCompany_country_code($company_country_code)
    {
        $this->company_country_code = $company_country_code;
    }
    /**
     * timezone
     *
     *
     * https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * timezone
     *
     *
     * https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
     *
     * @param string $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * Initializes this Company from an XML reader.
     *
     * @param \XMLReader $xml The reader to use to initialize this object.
     */
    public function initFromReader($xml)
    {
        $empty = $xml->isEmptyElement;

        if ($xml->hasAttributes) {
            $moreAttributes = $xml->moveToFirstAttribute();
            while ($moreAttributes) {
                if (!$this->setKnownAttribute($xml)) {
                    //skip unknown attributes...
                }
                $moreAttributes = $xml->moveToNextAttribute();
            }
        }

        if (!$empty) {
            $xml->read();
            while ($xml->nodeType != \XMLReader::END_ELEMENT) {
                if ($xml->nodeType != \XMLReader::ELEMENT) {
                    //no-op: skip any insignificant whitespace, comments, etc.
                }
                else if (!$xml->isEmptyElement && !$this->setKnownChildElement($xml)) {
                    $n = $xml->localName;
                    $ns = $xml->namespaceURI;
                    //skip the unknown element
                    while ($xml->nodeType != \XMLReader::END_ELEMENT && $xml->localName != $n && $xml->namespaceURI != $ns) {
                        $xml->read();
                    }
                }
                $xml->read(); //advance the reader.
            }
        }
    }


    /**
     * Sets a known child element of Company from an XML reader.
     *
     * @param \XMLReader $xml The reader.
     * @return bool Whether a child element was set.
     */
    protected function setKnownChildElement($xml) {
        $happened = false;
        if (($xml->localName == 'company_id') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->company_id = $child;
            $happened = true;
        }
        else if (($xml->localName == 'company_name') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->company_name = $child;
            $happened = true;
        }
        else if (($xml->localName == 'contact_person') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->contact_person = $child;
            $happened = true;
        }
        else if (($xml->localName == 'native_currency') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->native_currency = $child;
            $happened = true;
        }
        else if (($xml->localName == 'address') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->address = $child;
            $happened = true;
        }
        else if (($xml->localName == 'zip_code') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->zip_code = $child;
            $happened = true;
        }
        else if (($xml->localName == 'city') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->city = $child;
            $happened = true;
        }
        else if (($xml->localName == 'country_code') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->country_code = $child;
            $happened = true;
        }
        else if (($xml->localName == 'phone') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->phone = $child;
            $happened = true;
        }
        else if (($xml->localName == 'fax') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->fax = $child;
            $happened = true;
        }
        else if (($xml->localName == 'email') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->email = $child;
            $happened = true;
        }
        else if (($xml->localName == 'native_language') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->native_language = $child;
            $happened = true;
        }
        else if (($xml->localName == 'web_address') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->web_address = $child;
            $happened = true;
        }
        else if (($xml->localName == 'vat_code') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->vat_code = $child;
            $happened = true;
        }
        else if (($xml->localName == 'attributes') && (empty($xml->namespaceURI))) {
            $child = new \App\Traits\Attribute($xml);
            if (!isset($this->attributes)) {
                $this->attributes = array();
            }
            array_push($this->attributes, $child);
            $happened = true;
        }
        else if (($xml->localName == 'visbook_customer_id') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->visbook_customer_id = $child;
            $happened = true;
        }
        else if (($xml->localName == 'company_country_code') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->company_country_code = $child;
            $happened = true;
        }
        else if (($xml->localName == 'timezone') && (empty($xml->namespaceURI))) {
            $child = '';
            while ($xml->read() && $xml->hasValue) {
                $child = $child . $xml->value;
            }
            $this->timezone = $child;
            $happened = true;
        }
        return $happened;
    }

    /**
     * Sets a known attribute of Company from an XML reader.
     *
     * @param \XMLReader $xml The reader.
     * @return bool Whether an attribute was set.
     */
    protected function setKnownAttribute($xml) {

        return false;
    }

    /**
     * Writes the contents of this Company to an XML writer. The startElement is expected to be already provided.
     *
     * @param \XMLWriter $writer The XML writer.
     */
    public function writeXmlContents($writer)
    {
        if ($this->company_id) {
            $writer->startElementNs(null, 'company_id', null);
            $writer->text($this->company_id);
            $writer->endElement();
        }
        if ($this->company_name) {
            $writer->startElementNs(null, 'company_name', null);
            $writer->text($this->company_name);
            $writer->endElement();
        }
        if ($this->contact_person) {
            $writer->startElementNs(null, 'contact_person', null);
            $writer->text($this->contact_person);
            $writer->endElement();
        }
        if ($this->native_currency) {
            $writer->startElementNs(null, 'native_currency', null);
            $writer->text($this->native_currency);
            $writer->endElement();
        }
        if ($this->address) {
            $writer->startElementNs(null, 'address', null);
            $writer->text($this->address);
            $writer->endElement();
        }
        if ($this->zip_code) {
            $writer->startElementNs(null, 'zip_code', null);
            $writer->text($this->zip_code);
            $writer->endElement();
        }
        if ($this->city) {
            $writer->startElementNs(null, 'city', null);
            $writer->text($this->city);
            $writer->endElement();
        }
        if ($this->country_code) {
            $writer->startElementNs(null, 'country_code', null);
            $writer->text($this->country_code);
            $writer->endElement();
        }
        if ($this->phone) {
            $writer->startElementNs(null, 'phone', null);
            $writer->text($this->phone);
            $writer->endElement();
        }
        if ($this->fax) {
            $writer->startElementNs(null, 'fax', null);
            $writer->text($this->fax);
            $writer->endElement();
        }
        if ($this->email) {
            $writer->startElementNs(null, 'email', null);
            $writer->text($this->email);
            $writer->endElement();
        }
        if ($this->native_language) {
            $writer->startElementNs(null, 'native_language', null);
            $writer->text($this->native_language);
            $writer->endElement();
        }
        if ($this->web_address) {
            $writer->startElementNs(null, 'web_address', null);
            $writer->text($this->web_address);
            $writer->endElement();
        }
        if ($this->vat_code) {
            $writer->startElementNs(null, 'vat_code', null);
            $writer->text($this->vat_code);
            $writer->endElement();
        }
        if ($this->attributes) {
            foreach ($this->attributes as $i => $x) {
                $writer->startElementNs(null, 'attributes', null);
                $x->writeXmlContents($writer);
                $writer->endElement();
            }
        }
        if ($this->visbook_customer_id) {
            $writer->startElementNs(null, 'visbook_customer_id', null);
            $writer->text($this->visbook_customer_id);
            $writer->endElement();
        }
        if ($this->company_country_code) {
            $writer->startElementNs(null, 'company_country_code', null);
            $writer->text($this->company_country_code);
            $writer->endElement();
        }
        if ($this->timezone) {
            $writer->startElementNs(null, 'timezone', null);
            $writer->text($this->timezone);
            $writer->endElement();
        }
    }
}
