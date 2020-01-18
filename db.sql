CREATE TABLE IF NOT EXISTS users (
  UID varchar(64) NOT NULL,
  Name varchar(255) NOT NULL,
  EMail varchar(255) NOT NULL,
  Description LONGTEXT,
  ProfileImageID varchar(64),
  Rank int,
  PRIMARY KEY (UID)
);

CREATE TABLE IF NOT EXISTS followers (
  UID varchar(64) NOT NULL,
  FollowerUID varchar(64),
  FOREIGN KEY (UID) REFERENCES users(UID),
  FOREIGN KEY (FollowerUID) REFERENCES users(UID)
);

CREATE TABLE IF NOT EXISTS categories (
  CID varchar(64) NOT NULL,
  Name varchar(255) NOT NULL,
  PRIMARY KEY (CID)
);

CREATE TABLE IF NOT EXISTS posts (
  PID varchar(64) NOT NULL,
  CID varchar(64) NOT NULL,
  UID varchar(64) NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT,
  PRIMARY KEY (PID),
  FOREIGN KEY (CID) REFERENCES categories(CID),
  FOREIGN KEY (UID) REFERENCES users(UID)
);

CREATE TABLE IF NOT EXISTS comments (
  CMTID varchar(64) NOT NULL,
  PID varchar(64),
  CMTID_F varchar(64),
  UID varchar(64) NOT NULL,
  CreatedAt DATETIME NOT NULL,
  Content LONGTEXT,
  PRIMARY KEY (CMTID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (CMTID_F) REFERENCES comments (CMTID),
  FOREIGN KEY (UID) REFERENCES users (UID),
  CONSTRAINT chk_null check (
    CMTID_F IS NOT NULL
    OR PID IS NOT NULL
  )
);

CREATE TABLE IF NOT EXISTS likes (
  LID varchar(64) NOT NULL,
  PID varchar(64),
  CMTID varchar(64),
  UID varchar(64),
  PRIMARY KEY (LID),
  FOREIGN KEY (PID) REFERENCES posts (PID),
  FOREIGN KEY (CMTID) REFERENCES comments(CMTID),
  CONSTRAINT chk_null check (
    CMTID IS NOT NULL
    OR PID IS NOT NULL
  )
);

CREATE TABLE IF NOT EXISTS verify (
  VID varchar(64) NOT NULL,
  EMail varchar(255) NOT NULL,
  PRIMARY KEY (VID)
);

CREATE TABLE IF NOT EXISTS sessions (
  SID varchar(64) NOT NULL,
  UID varchar(64) NOT NULL,
  PRIMARY KEY (SID),
  FOREIGN KEY (UID) REFERENCES users (UID)
);
