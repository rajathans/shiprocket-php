<?php 

namespace Shiprocket\Resources;

trait Couriers
{	
	/**
	 * Get a list of serviceable couriers between two pincodes
	 *
	 * @param 	string 		$pickup_postcode
	 * @param 	string 		$delivery_postcode
	 * @param 	bool 		$is_cod
	 * @param 	float 		$weight
	 * @param 	string 		$shiprocket_order_id
	 * @return 	void
	 */
    public function checkServiceability(
		$pickup_postcode, 
		$delivery_postcode, 
		$is_cod = 0, 
		$weight = 0, 
		$shiprocket_order_id = 0
	) {
        return $this->request(
			'get', 
			'courier/serviceability?' .
				'pickup_postcode=' . $pickup_postcode . '&' .
				'delivery_postcode=' . $delivery_postcode . '&' .
				'weight=' . $weight . '&' .
				'cod=' . $is_cod . '&' .
				'order_id=' . $shiprocket_order_id
		);
	}
	
	public function assignAWBs(
		$shipment_ids = [],
		$courier_id,
		$weight
	) {
		if (count($shipment_ids) > 1) {
			return $this->request(
				'post', 
				'courier/assign/awb',
				[
					'shipment_id' => $shipment_ids
				]
			);
		}

		return $this->request(
			'post', 
			'courier/assign/awb',
			[
				'shipment_id' => $shipment_ids,
				'courier_id' => $courier_id,
				'weight' => $weight
			]
		);
	}

    /**
     * Makes a request to the Shiprocket API and returns the response.
     *
     * @param    string $verb       The Http verb to use
     * @param    string $path       The path of the APi after the domain
     * @param    array  $parameters Parameters
     *
     * @return   stdClass The JSON response from the request
     * @throws   Exception
     */
    abstract protected function request($verb, $path, $parameters = []);
}
