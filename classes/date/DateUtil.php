<?php

class DateUtil {

	public static function diff(string $timestamp) : ?string {
		$start_date = new DateTime($timestamp);
		$since_start = $start_date->diff(new DateTime());

		if ($since_start->y != 0) {
			$years = $since_start->y;
			return self::multi($years, "Jahr");
		} else if ($since_start->m != 0) {
			$months = $since_start->m;
			return self::multi($months, "Monat");
		} else if ($since_start->d != 0) {
			$days = $since_start->d;
			return self::multi($days, "Tag");
		} else if ($since_start->h != 0) {
			$hours = $since_start->h;
			return self::multi($hours, "Stunde", "n");
		} else if ($since_start->i != 0) {
			$minutes = $since_start->i;
			return self::multi($minutes, "Minute", "n");
		}

		$seconds = $since_start->s;
		return self::multi($seconds, "Sekunde", "n");
	}

	private static function multi(int $amount, string $name, string $multi = "en") {
		return $amount == 1 ? $amount . " " . $name : $amount . " " . $name . $multi;
	}

}

?>
