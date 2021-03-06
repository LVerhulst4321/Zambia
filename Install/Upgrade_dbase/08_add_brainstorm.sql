## This script creates the brainstorm user, the brainstorm permissions, and links them.
## This script also modifies the Sessions table to allow some columns to be null to support
## less stringent validation for brainstorm stage.
INSERT INTO `Phases` VALUES (6,'Brainstorm',1,'Special brainstorm pages are accessible.');
INSERT INTO `PermissionAtoms` VALUES (18,'Brainstorm',null,'BrainstormWelcome','Use for special brainstorm user and pages.');
INSERT INTO `PermissionRoles` VALUES (5,'Brainstorm','Use for Brainstorm pages');
INSERT INTO `Permissions` VALUES (21,18,6,5,null);
INSERT INTO `Participants` (badgeid, pubsname, password, bestway, interested, bio)
 VALUES ('brainstorm',null,'ecf65a5d41056d7dd4d548e3ef200476',null,null,null);
INSERT INTO `UserHasPermissionRole` VALUES ('brainstorm',5);
INSERT INTO `Divisions` (divisionid, divisionname, display_order) VALUES (6, "Unspecified", 6);
INSERT INTO `RoomSets` (roomsetid, roomsetname, display_order) VALUES (4, "Unspecified", 99);
