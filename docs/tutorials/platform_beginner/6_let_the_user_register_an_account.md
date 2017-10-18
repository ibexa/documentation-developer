# Step 6 - Let the User register an account

We are trying to let our friends put their Rides into our website. We would like to let them create Rides. As an Administrator of the website you could create the Users but you prefer to let them create their own content.

## Create a User Group for the Go Bike Members

From the Admin Panel, click on the *Create button* and filter by Group checking _Users_. You can create a User Group named `Go Bike Members`.

## Create a Folder for your Rides from the Go Bike Members

In the Content creation view, select Folder and create a Folder named `members-rides ` into the Folder `all-rides` already existing. The Go Bike Members will have the access rights in creation mode only in this Folder.

## Add a Role Policy to the Go Bike Members

In the Admin Panel, create a new Role Policy. You will name it *Bikers* and assign it to the group *Go Bike Members*.

Now, we want to set the Policies for the Bikers.

- User/Login
- User/Password
- Content/Read with Limitations: only Not Locked content
- Content/Create with Limitations: only Rides and Points of Interest 


!!! note
    The Limitations are powerful to finetune the ACL of the Users.
    See [the documentation about Limitations for a more technical approach] (guide/repository/#usergrouplimitation)
    
    See also the Cookbook [Authenticating a user with multiple user providers](cookbook/authenticating_a_user_with_multiple_user_providers/)
    
Once the Policies are set, assign your Role *Bikers* to the User Group *Go Bike Members*.

## Add the registration possible

For the Anonymous User add the User/Register policy.
Then you could access from the website to the URL: http://127.0.0.1/register and create a new user and login.

## Try the validation of your future Go Bike Users

Register a new User on the Register Form.
Then log in the back office as an Administrator and go to the Users page. Select the user you have just created and Move them into your *Go Bike Member* user group.

## Create content as a Go Bike Member

Then log in again into the back office with your new user credentials.
You have now the possibility to create new Rides and Points of Interest only.

