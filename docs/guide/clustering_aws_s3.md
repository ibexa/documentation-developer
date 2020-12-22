# Clustering with Amazon AWS S3

When setting up clustering, you can use Amazon AWS S3 as a binary handler,
meaning AWS S3 will be used to store binary files.

!!! tip

    Before you start, you should be familiar with the [clustering](../guide/clustering.md) documentation.

## Set up AWS S3 account

1.  Go to <https://aws.amazon.com/> and create an account.
An [existing Amazon account can be used](http://docs.aws.amazon.com/AmazonS3/latest/gsg/SigningUpforS3.html).
1.  [Choose a region](http://docs.aws.amazon.com/storagegateway/latest/userguide/available-regions-intro.html).
The example below uses EU (Ireland): `eu-west-1`
1.  Create a bucket in your chosen region and make note of the bucket name:
<http://docs.aws.amazon.com/AmazonS3/latest/gsg/CreatingABucket.html>.
1.  Go to the [IAM Management Console](https://console.aws.amazon.com/iam/home#/users) and create a user.
See <http://docs.aws.amazon.com/AmazonS3/latest/dev/s3-access-control.html>.
1.  Then create a group and assign the user to the group.
1.  Assign policies to the group. The `AmazonS3FullAccess` policy gives read/write access to your bucket.
1.  Still in the IAM console, view the user you created. Click the "Security credentials" tab.
1.  Click "Create access key" and make note of the "Access key ID" and the "Secret access key".
The secret key cannot be retrieved again after the key has been created, so don't lose it.
(However, you can create new keys if needed.)

!!! note

    Make sure that your bucket is [configured as Public](https://docs.aws.amazon.com/AmazonS3/latest/user-guide/block-public-access-bucket.html) to avoid facing 403 errors, as the current S3 handler is meant to store files publicly so they can be served directly from S3.
    
## Set up [[= product_name =]] for AWS S3

In your [[= product_name =]] root directory, run `php composer.phar require league/flysystem-aws-s3-v3`.
In your [[= product_name =]] configuration, e.g. `config/packages/ezplatform.yaml`, set up the AWS S3 client:

``` yaml
services:
    Aws\S3\S3Client:
        arguments:
            -
                version: latest
                region: eu-west-1 # The region string of your chosen region
                credentials:
                    key: ABCDEF... # Your AWS key ID
                    secret: abc123... # Your AWS secret key
```

In the same [[= product_name =]] configuration, set up the Flysystem adapter that uses the S3 client:

``` yaml
oneup_flysystem:
    adapters:
        aws_s3_adapter:
            awss3v3:
                client: amazon.s3_client
                bucket: my-bucket # Your bucket name
                prefix: '%database_name%'
```

In the same place, set up the binary data handler for the S3 adapter:

``` yaml
ez_io:
    binarydata_handlers:
        aws_s3:
            flysystem:
                adapter: aws_s3_adapter
```

!!! note

    `aws_s3` is an arbitrary handler identifier that is used in the config block below.
    You can configure multiple handlers.

    For example, you could configure one called `gcloud_storage` for a third-party (community-supported)
    [Google Cloud Storage adapter](https://github.com/thephpleague/flysystem#community-supported).

In your [[= product_name =]] system settings, e.g. `config/packages/ezplatform.yaml`, enable the binary data handler:

``` yaml
ezplatform:
    system:
        default:
            io:
                binarydata_handler: aws_s3
                # Also remember to use DFS for metadata_handler to avoid expensive lookups to S3 (see Clustering guide)
                # metadata_handler: dfs
```

Clear all caches and reload, and that's it.

## Migrate your existing binary data to S3

You can [migrate existing binary data](../guide/clustering.md#migrating-to-a-cluster-setup) to S3 using the `php bin/console ezplatform:io:migrate-files` command
which was added in [EZP-25946](https://jira.ez.no/browse/EZP-25946).
