--User Creation
CREATE USER 'couchinn'@'localhost' IDENTIFIED BY 'FZxMQCESvfwDPyQC';
--Grants
GRANT SELECT,INSERT,UPDATE,DELETE ON couchinn.* TO 'couchinn'@'%';
FLUSH PRIVILEGES;