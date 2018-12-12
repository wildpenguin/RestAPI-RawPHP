CREATE TABLE `apiUsers` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user` text NOT NULL,
 `password` text NOT NULL,
 PRIMARY KEY (`id`)
);
INSERT INTO `apiUsers` (`user`, `password`) VALUES
('apiuser', 'abc123');	

CREATE TABLE `todoItem` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `listId` int(11) NOT NULL,
 `item` text NOT NULL,
 `status` enum('DONE','TODO','','') NOT NULL,
 PRIMARY KEY (`id`)
);

CREATE TABLE `todoList` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` text NOT NULL,
 `userId` int(11) NOT NULL,
 PRIMARY KEY (`id`)
);