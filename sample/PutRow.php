<?php
    include('griddb_php_client.php');

    $factory = StoreFactory::get_default();

    $containerName = "SamplePHP_PutRow";

    try {
        // Get GridStore object
        $gridstore = $factory->get_store(array("notificationAddress" => $argv[1],
                        "notificationPort" => $argv[2],
                        "clusterName" => $argv[3],
                        "user" => $argv[4],
                        "password" => $argv[5]
                    ));

        // When operations such as container creation and acquisition are performed, it is connected to the cluster.
        $gridstore->get_container("containerName");
        echo("Connect to Cluster\n");

        // Create a collection container
        $col = $gridstore->put_container(
            $containerName,
            array(array("id" => GS_TYPE_INTEGER),
                  array("productName" => GS_TYPE_STRING),
                  array("count" => GS_TYPE_INTEGER)),
            GS_CONTAINER_COLLECTION
        );
        echo("Create Collection name=$containerName\n");

        // Register a row
        // (1)Get the container
        $col1 = $gridstore->get_container($containerName);
        if ($col1 == null) {
            echo("ERROR Container not found. name=$containerName\n");
        }

        // (2)Create an empty Row object
        $row = $col1->create_row();

        // (3)Set column value
        $row->set_field_by_integer(0, 0);
        $row->set_field_by_string(1, "display");
        $row->set_field_by_integer(2, 150);

        // (4)Register the row
        $col1->put_row($row);
        echo("Put Row\n");
        echo("success!\n");
    } catch (GSException $e) {
        echo($e->what()."\n");
        echo($e->get_code()."\n");
    }
?>
