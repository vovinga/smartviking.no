<?php
$connection = new \OpenCloud\Rackspace(RACKSPACE_US, array('username' => $data['Username'], 'apiKey' => $data['APIKey'] ));
$objstore = $connection->ObjectStore('cloudFiles', $data['ServerRegion'], "publicURL");