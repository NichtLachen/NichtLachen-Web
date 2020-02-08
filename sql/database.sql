CREATE TABLE IF NOT EXISTS users (
  UID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  JoinedAt DATETIME NOT NULL,
  Name varchar(255) NOT NULL,
  NameChangedAt DATETIME NOT NULL,
  OldName varchar(255),
  Password varchar(255),
  EMail varchar(255) NOT NULL,
  Description LONGTEXT,
  Rank int UNSIGNED,
  PRIMARY KEY (UID)
);

CREATE TABLE IF NOT EXISTS followers (
  UID bigint UNSIGNED NOT NULL,
  FollowerUID bigint UNSIGNED NOT NULL,
  FOREIGN KEY (UID) REFERENCES users(UID),
  FOREIGN KEY (FollowerUID) REFERENCES users(UID)
);

CREATE TABLE IF NOT EXISTS categories (
  CID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  Parent bigint UNSIGNED,
  Super TINYINT(1) NOT NULL,
  Name varchar(255) NOT NULL,
  PRIMARY KEY (CID),
  FOREIGN KEY (Parent) REFERENCES categories(CID)
);

CREATE TABLE IF NOT EXISTS posts (
  PID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  CID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT NOT NULL,
  PRIMARY KEY (PID),
  FOREIGN KEY (CID) REFERENCES categories(CID),
  FOREIGN KEY (UID) REFERENCES users(UID)
);

CREATE TABLE IF NOT EXISTS posts_verify (
  PID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  CID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT NOT NULL,
  PRIMARY KEY (PID),
  FOREIGN KEY (CID) REFERENCES categories(CID),
  FOREIGN KEY (UID) REFERENCES users(UID)
);

CREATE TABLE IF NOT EXISTS posts_verify_accept (
  APID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  PID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  Value TINYINT(1) NOT NULL,
  PRIMARY KEY (APID),
  FOREIGN KEY (PID) REFERENCES posts_verify(PID),
  FOREIGN KEY (UID) REFERENCES users(UID)
);

CREATE TABLE IF NOT EXISTS comments (
  CMTID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  PID bigint UNSIGNED NOT NULL,
  UID_F bigint UNSIGNED,
  UID bigint UNSIGNED NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT NOT NULL,
  PRIMARY KEY (CMTID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (UID) REFERENCES users (UID),
  FOREIGN KEY (UID_F) REFERENCES users (UID)
);

CREATE TABLE IF NOT EXISTS likes (
  LID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  PID bigint UNSIGNED,
  CMTID bigint UNSIGNED,
  UID bigint UNSIGNED NOT NULL,
  Value TINYINT(1) NOT NULL,
  PRIMARY KEY (LID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (CMTID) REFERENCES comments(CMTID),
  FOREIGN KEY (UID) REFERENCES users (UID),
  CONSTRAINT chk_null check (
    CMTID IS NOT NULL
    OR PID IS NOT NULL
  )
);

CREATE TABLE IF NOT EXISTS favorites (
  FID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  PID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  PRIMARY KEY (FID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (UID) REFERENCES users (UID)
);

CREATE TABLE IF NOT EXISTS verify (
  VID varchar(64) NOT NULL,
  Name varchar(255) NOT NULL,
  Password varchar(255) NOT NULL,
  EMail varchar(255) NOT NULL,
  ExpiresAt DATETIME NOT NULL,
  PRIMARY KEY (VID)
);

CREATE TABLE IF NOT EXISTS sessions (
  SID varchar(64) NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  ExpiresAt DATETIME NOT NULL,
  PRIMARY KEY (SID),
  FOREIGN KEY (UID) REFERENCES users (UID)
);

CREATE TABLE IF NOT EXISTS settings (
  SVID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  Name varchar(255) NOT NULL,
  Value varchar(255) NOT NULL,
  PRIMARY KEY (SVID),
  FOREIGN KEY (UID) REFERENCES users (UID)
);
