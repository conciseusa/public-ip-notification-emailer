# public-ip-notification-emailer

Sometimes you want to know the IP address of a remote server, but it can have a dynamic address that can change. There are services that can provide this service, but I wanted something free and simple that also provided a heartbeat message from the remote server.

The idea is to have a bash script on a cron job that will call a remote server. This remote server will then know the public IP address of the caller and can send the information to an email address. Below is sample PHP code for the relay server. Now the email messages will have the remote IP address and the emails also serve as heartbeat messages.

A short coming of this system is you need to wait for the next cron run to get a changed address. That was not an issue in my application.
