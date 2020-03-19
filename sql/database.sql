CREATE TABLE IF NOT EXISTS users (
  UID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  JoinedAt DATETIME NOT NULL,
  Name varchar(255) NOT NULL,
  NameChangedAt DATETIME NOT NULL,
  OldName varchar(255),
  Password varchar(255),
  EMail varchar(255) NOT NULL,
  Description LONGTEXT,
  PRIMARY KEY (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ranks (
  UID bigint UNSIGNED NOT NULL,
  Rank int UNSIGNED,
  FOREIGN KEY (UID) REFERENCES users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS followers (
  UID bigint UNSIGNED NOT NULL,
  FollowerUID bigint UNSIGNED NOT NULL,
  FOREIGN KEY (UID) REFERENCES users(UID),
  FOREIGN KEY (FollowerUID) REFERENCES users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
  CID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  Parent bigint UNSIGNED,
  Super TINYINT(1) NOT NULL,
  Name varchar(255) NOT NULL,
  PRIMARY KEY (CID),
  FOREIGN KEY (Parent) REFERENCES categories(CID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
  PID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  CID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT NOT NULL,
  PRIMARY KEY (PID),
  FOREIGN KEY (CID) REFERENCES categories(CID),
  FOREIGN KEY (UID) REFERENCES users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts_verify (
  PID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  CID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT NOT NULL,
  PRIMARY KEY (PID),
  FOREIGN KEY (CID) REFERENCES categories(CID),
  FOREIGN KEY (UID) REFERENCES users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts_verify_accept (
  PID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  Value TINYINT(1) NOT NULL,
  FOREIGN KEY (PID) REFERENCES posts_verify(PID),
  FOREIGN KEY (UID) REFERENCES users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS comments (
  CMTID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  PID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT NOT NULL,
  PRIMARY KEY (CMTID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (UID) REFERENCES users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS comment_reply (
  CMTID bigint UNSIGNED NOT NULL,
  UID_F bigint UNSIGNED NOT NULL,
  ReplaceValue varchar(256) NOT NULL,
  FOREIGN KEY (CMTID) REFERENCES comments (CMTID),
  FOREIGN KEY (UID_F) REFERENCES users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS favorites (
  FID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  PID bigint UNSIGNED NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  PRIMARY KEY (FID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (UID) REFERENCES users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS verify (
  VID varchar(64) NOT NULL,
  Name varchar(255) NOT NULL,
  Password varchar(255) NOT NULL,
  EMail varchar(255) NOT NULL,
  ExpiresAt DATETIME NOT NULL,
  PRIMARY KEY (VID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sessions (
  SID varchar(64) NOT NULL,
  UID bigint UNSIGNED NOT NULL,
  ExpiresAt DATETIME NOT NULL,
  PRIMARY KEY (SID),
  FOREIGN KEY (UID) REFERENCES users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
  UID bigint UNSIGNED NOT NULL,
  Name varchar(255) NOT NULL,
  Value varchar(255) NOT NULL,
  FOREIGN KEY (UID) REFERENCES users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reports (
  RPID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  PID bigint UNSIGNED,
  CMTID bigint UNSIGNED,
  RUID bigint UNSIGNED,
  Reason TEXT,
  UID bigint UNSIGNED NOT NULL,
  PRIMARY KEY(RPID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (CMTID) REFERENCES comments(CMTID),
  FOREIGN KEY (RUID) REFERENCES users (UID),
  FOREIGN KEY (UID) REFERENCES users (UID),
  CONSTRAINT chk_null check (
    CMTID IS NOT NULL
    OR PID IS NOT NULL
    OR RUID IS NOT NULL
  )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
