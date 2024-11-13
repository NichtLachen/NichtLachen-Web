DELIMITER !!

CREATE EVENT IF NOT EXISTS check_expire
  ON SCHEDULE EVERY 15 MINUTE
  DO
    BEGIN
      DELETE FROM verify WHERE ExpiresAt < NOW();
      DELETE FROM sessions WHERE ExpiresAt < NOW();
      DELETE FROM resetpassword WHERE ExpiresAt < NOW();
    END!!

CREATE EVENT IF NOT EXISTS top_posts_update
  ON SCHEDULE EVERY 15 MINUTE
  DO
    BEGIN
      DELETE FROM top_posts;
      INSERT INTO top_posts SELECT posts.PID, posts.CreatedAt, likes_sum.total_likes FROM (
        SELECT PID, SUM(likes.Value) AS total_likes FROM likes WHERE PID IS NOT NULL GROUP BY likes.PID HAVING total_likes > 0
      ) AS likes_sum INNER JOIN posts ON posts.PID = likes_sum.PID;
    END!!
