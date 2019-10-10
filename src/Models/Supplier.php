<?php namespace Rtbs\ApiHelper\Models;


class Supplier {
    private $supplier_key;
    private $name;
    private $description;
    private $phone;
    private $email;
    private $url;
    private $address;
    private $latlng;
    private $currency_code;
    private $timezone;
	private $cancellation_policies;

    /** @var Tour[] $tours  */
    private $tours = array();

    private $tour_locations = array();
    private $media = array();

    /**
     * @return mixed
     */
    public function get_supplier_key() {
        return $this->supplier_key;
    }

    /**
     * @param mixed $supplier_key
     */
    public function set_supplier_key($supplier_key) {
        $this->supplier_key = $supplier_key;
    }

    /**
     * @return mixed
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function set_name($name) {
        $this->name = $name;
    }

    /**
     * @return Tour[]
     */
    public function get_tours() {
        return $this->tours;
    }

    /**
     * @param string $tour_key
     * @return Tour|null
     */
    public function get_tour($tour_key) {
        foreach ($this->tours as $tour) {
            if ($tour->get_tour_key() === $tour_key) {
                return $tour;
            }
        }

        return null;
    }

    /**
     * @return string[]
     */
    public function get_tour_keys() {
        $tour_keys = array();

        foreach($this->tours as $tour) {
            $tour_keys[] = $tour->get_tour_key();
        }

        return $tour_keys;
    }

    /**
     * @return mixed
     */
    public function get_description() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function set_description($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function get_phone() {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function set_phone($phone) {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function get_email() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function set_email($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function get_url() {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function set_url($url) {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function get_address() {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function set_address($address) {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function get_latlng() {
        return $this->latlng;
    }

    /**
     * @param mixed $latlng
     */
    public function set_latlng($latlng) {
        $this->latlng = $latlng;
    }

	/**
	 * @return string
	 */
	public function get_currency_code() {
		return $this->currency_code;
	}

	/**
	 * @return string
	 */
	public function get_timezone() {
		return $this->timezone;
	}


	/**
	 * @return string
	 */
	public function get_currency_symbol() {
		switch ($this->currency_code) {

			case 'NZD':
				return 'NZD $';

			case 'AUD':
				return 'AUD $';

			default:
				return $this->currency_code;
		}
	}


    /**
     * @param string $currency_code
     */
    public function set_currency_code($currency_code) {
        $this->currency_code = $currency_code;
    }


	/**
	 * @param string $timezone
	 */
	public function set_timezone($timezone) {
		$this->timezone = $timezone;
	}
    /**
     * @return Media[]
     */
    public function get_media() {
        return $this->media;
    }

    public function add_tour_location($tour_location) {
        $this->tour_locations[] = $tour_location;
    }

    public function add_media(Media $media) {
        $this->media[] = $media;
    }

    public function add_tour(Tour $tour) {
        $this->tours[] = $tour;
    }

	/**
	 * @return mixed
	 */
	public function get_cancellation_policies()
	{
		return $this->cancellation_policies;
	}

	/**
	 * @param mixed $cancellation_policies
	 */
	public function set_cancellation_policies($cancellation_policies)
	{
		$this->cancellation_policies = $cancellation_policies;
	}
    
    

    public static function fromRaw($raw_supplier) {
        $supplier = new Supplier();

        $supplier->set_name($raw_supplier->name);
        $supplier->set_supplier_key($raw_supplier->supplier_key);

        $supplier->set_description(property_exists($raw_supplier, 'description') ? $raw_supplier->description : "");
        $supplier->set_phone(property_exists($raw_supplier, 'phone') ? $raw_supplier->phone : "");
        $supplier->set_email(property_exists($raw_supplier, 'email') ? $raw_supplier->email : "");
        $supplier->set_url(property_exists($raw_supplier, 'url') ? $raw_supplier->url : "");
        $supplier->set_address(property_exists($raw_supplier, 'address') ? $raw_supplier->address : "");
        $supplier->set_latlng(property_exists($raw_supplier, 'latlng') ? $raw_supplier->latlng : "");
	    $supplier->set_currency_code(property_exists($raw_supplier, 'currency_code') ? $raw_supplier->currency_code : "");
	    $supplier->set_timezone(property_exists($raw_supplier, 'timezone') ? $raw_supplier->timezone : date_default_timezone_get());
	    $supplier->set_cancellation_policies(property_exists($raw_supplier, 'cancellation_policies') ? $raw_supplier->cancellation_policies : array());

        if(property_exists($raw_supplier, 'locations') && is_array($raw_supplier->locations)) {
            foreach($raw_supplier->locations as $raw_location) {
                $supplier->add_tour_location($raw_location);
            }
        }

        if(property_exists($raw_supplier, 'media') && is_array($raw_supplier->media)) {
            foreach($raw_supplier->media as $raw_media) {
                $supplier->add_media(Media::from_raw($raw_media));
            }
        }

        if(property_exists($raw_supplier, 'tours') && is_array($raw_supplier->tours)) {
            foreach($raw_supplier->tours as $raw_tour) {
                $supplier->add_tour(Tour::from_raw($raw_tour));
            }
        }

        return $supplier;
    }
}