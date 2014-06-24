<?php

$connection = new MongoClient();

$db = $connection->icebreaker;

// select a collection:
$collection = $db->foobar;

$doc = array(
        "name" => "MongoDB",
        "type" => "database",
        "count" => 1,
        "info" => (object)array( "x" => 203, "y" => 102),
        "versions" => array("0.9.7", "0.9.8", "0.9.9")
);

;

$collection->insert( $doc );

// find oe document
$document = $collection->findOne();

print"<pre>";print_r($document);print"</pre>";


// for ( $i = 0; $i < 100; $i++ )
// {
//     $collection->insert( array( 'i' => $i, "field{$i}" => $i * 2 ) );
// }

// echo $collection->count();

// find all collection
// $cursor = $collection->find();
// foreach ( $cursor as $id => $value )
// {
//     echo "$id: ";
//     print"<pre>";print_r($value);print"</pre>";
// }

// find by criteria
// $query = array( 'i' => 71 );
// $cursor = $collection->find( $query );

// while ( $cursor->hasNext() )
// {
//     print"<pre>";print_r( $cursor->getNext() );print"</pre>";
// }



?>