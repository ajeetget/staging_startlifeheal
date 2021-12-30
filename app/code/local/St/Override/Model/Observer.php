<?php

class St_Override_Model_Observer
{
		public function customerSaveAfter($observer)
		{ 
			$customer = $observer->getEvent()->getCustomer(); //customer detail
			//$customer->setStartingdate(now());
			//$customer->setEndingdate(now());
			//$customer->save();
			
		}
}
