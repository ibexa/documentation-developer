# Setting up Amazon AWS S3 clustering

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

## Set up eZ Platform for AWS S3

In your eZ Platform root directory, run `php composer.phar require league/flysystem-aws-s3-v3`.
In your eZ Platform configuration, e.g. `app/config/config.yml`, set up the AWS S3 client:

``` yaml
services:
    amazon.s3_client:
        class: Aws\S3\S3Client
        arguments:
            -
                version: "latest"
                region: "eu-west-1" # The region string of your chosen region
                credentials:
                    key: "ABCDEF..." # Your AWS key ID
                    secret: "abc123..." # Your AWS secret key
```

Still in your eZ Platform configuration, e.g. `app/config/config.yml`,
set up the Flysystem adapter that uses the S3 client:

``` yaml
oneup_flysystem:
    adapters:
        aws_s3_adapter:
            awss3v3:
                client: amazon.s3_client
                bucket: "my-bucket" # Your bucket name
                prefix: "%database_name%"
```

In the same place, set up the binary data handler for the S3 adapter:

``` yaml
ez_io:
    binarydata_handlers:
        aws_s3:
            flysystem:
                adapter: aws_s3_adapter
```

In your eZ Platform system settings, e.g. `app/config/ezplatform.yml`, enable the binary data handler:

``` yaml
ezpublish:
    system:
        default:
            io:
                binarydata_handler: aws_s3
```

Clear all caches and reload, and that's it.

## Migrate your existing binary data to S3

Since 1.7.4 you can [migrate existing binary data](../guide/clustering.md#migration) to S3 using the `php app/console ezplatform:io:migrate-files` command
which was added in [EZP-25946](https://jira.ez.no/browse/EZP-25946).
