# Notes

## Passwords

Databases in cPanel do not have passwords.

Authorized users (which do have passwords) are added to each database.

Your .env file should look like this (one set of connection parameters per database):

```
DB_HOSTNAME=localhost
DB_USERNAME=rmlbzgeb_mike
DB_PASSWORD="the user's password, not the database password"
DB_DATABASE=rmlbzgeb_rmlbb
```

When changing cPanel passwords that affect the databases, not only does **/.env** need to be updated accordingly... so does **/phpBB3/config.php**... which also has database connection info for the message board.

When making changes to any of the above in cPanel, the changes will take effect on the website nearly immediately.

## Remote DB Connection

You can connect to a remote MySQL database with Workbench through an SSH tunnel.

First you'll need to enable SSH in cPanel. Here's a video with the instructions: https://www.namecheap.com/support/knowledgebase/article.aspx/10040/2210/how-to-enable-ssh-shell-in-cpanel/
