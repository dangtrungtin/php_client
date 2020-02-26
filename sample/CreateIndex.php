<?php
    include('griddb_php_client.php');

    $factory = StoreFactory::get_default();

    $containerName = "SamplePHP_Index";

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

        // Get the container
        $container = $gridstore->get_container($containerName);
        if ($container == null) {
            echo("ERROR Container not found. name=$containerName\n");
        }

        // Create an index
        $container->create_index("count", GS_INDEX_FLAG_HASH);
        echo("Create Index\n");
        echo("success!\n");
    } catch (GSException $e) {
        echo($e->what()."\n");
        echo($e->get_code()."\n");
    }
?>
