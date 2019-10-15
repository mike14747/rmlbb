DROP DATABASE IF EXISTS rmlbb;
CREATE DATABASE rmlbb;
USE rmlbb;

set foreign_key_checks=0;

-- --------------------------------------------------------

CREATE TABLE champions (
    season_id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    season_year varchar(4) NOT NULL,
    winning_team varchar(40) NOT NULL,
    winning_manager varchar(60) NOT NULL,
    losing_team varchar(40) NOT NULL,
    losing_manager varchar(50) NOT NULL,
    PRIMARY KEY (season_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE cur_roster (
    player_name varchar(40) NOT NULL,
    rml_team varchar(40) NOT NULL,
    exp tinyint(2) UNSIGNED NOT NULL,
    salary int(3) NOT NULL,
    y varchar(1) NOT NULL,
    c varchar(1) NOT NULL,
    real_team varchar(40) NOT NULL,
    b_t varchar(3) NOT NULL,
    dob varchar(10) NOT NULL,
    pos varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE cur_season_nav (
    nav_id int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    nav_text varchar(40) NOT NULL,
    page_header varchar(40) NOT NULL,
    display tinyint(1) UNSIGNED NOT NULL,
    urlref varchar(40) NOT NULL,
    PRIMARY KEY (nav_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE divisions (
    division_id tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT,
    division varchar(10) NOT NULL,
    PRIMARY KEY (division_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE downloads (
    download_id int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    description varchar(60) NOT NULL,
    file_name varchar(60) NOT NULL,
    display tinyint(1) UNSIGNED NOT NULL,
    download_order int(3) UNSIGNED NOT NULL,
    PRIMARY KEY (download_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE events (
    event_id smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    eventdate date NOT NULL DEFAULT '0000-00-00',
    eventdesc varchar(200) NOT NULL,
    PRIMARY KEY (event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE hitter_usage (
    hitter_name varchar(40) NOT NULL,
    rml_team varchar(40) NOT NULL,
    ops decimal(4,3) NOT NULL,
    mlb_ab int(3) UNSIGNED NOT NULL,
    full varchar(1) NOT NULL,
    unl varchar(1) NOT NULL,
    rml_ab int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE links (
    link_id smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    linkname varchar(50) NOT NULL DEFAULT '',
    urlref varchar(50) NOT NULL DEFAULT '',
    display tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
    displayorder smallint(3) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (link_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE lzps (
    lzp_id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    year year(4) NOT NULL,
    file_name varchar(40) NOT NULL,
    navbar_name varchar(40) NOT NULL,
    PRIMARY KEY (lzp_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE managerdir (
    team_id smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    conference char(2) NOT NULL DEFAULT '',
    division_id tinyint(1) NOT NULL,
    FOREIGN KEY (division_id) REFERENCES divisions(division_id) ON DELETE RESTRICT ON UPDATE CASCADE,
    teamname varchar(30) NOT NULL DEFAULT '',
    description1 varchar(255) NOT NULL DEFAULT '',
    manager1 varchar(50) NOT NULL DEFAULT '',
    address1a varchar(80) NOT NULL DEFAULT '',
    address1b varchar(80) NOT NULL DEFAULT '',
    city1 varchar(50) NOT NULL DEFAULT '',
    state1 varchar(20) NOT NULL DEFAULT '',
    country1 varchar(20) NOT NULL DEFAULT '',
    zip1 varchar(20) NOT NULL DEFAULT '',
    phone1a varchar(20) NOT NULL DEFAULT '',
    phone1b varchar(20) NOT NULL DEFAULT '',
    email1a varchar(80) NOT NULL DEFAULT '',
    email1b varchar(80) NOT NULL DEFAULT '',
    description2 varchar(255) NOT NULL DEFAULT '',
    manager2 varchar(50) NOT NULL DEFAULT '',
    address2a varchar(80) NOT NULL DEFAULT '',
    address2b varchar(80) NOT NULL DEFAULT '',
    city2 varchar(50) NOT NULL DEFAULT '',
    state2 varchar(20) NOT NULL DEFAULT '',
    country2 varchar(20) NOT NULL DEFAULT '',
    zip2 varchar(20) NOT NULL DEFAULT '',
    phone2a varchar(20) NOT NULL DEFAULT '',
    phone2b varchar(20) NOT NULL DEFAULT '',
    email2a varchar(80) NOT NULL DEFAULT '',
    email2b varchar(80) NOT NULL DEFAULT '',
    PRIMARY KEY (team_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE pitcher_usage (
    pitcher_name varchar(40) NOT NULL,
    rml_team varchar(40) NOT NULL,
    real_app int(3) UNSIGNED NOT NULL,
    real_st tinyint(2) UNSIGNED NOT NULL,
    real_ip decimal(4,1) NOT NULL,
    ops decimal(4,3) NOT NULL,
    unl varchar(1) NOT NULL,
    rml_st tinyint(2) UNSIGNED NOT NULL,
    rml_rel_app tinyint(2) UNSIGNED NOT NULL,
    rml_ip int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE rmlnews (
    news_id smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    newsheader varchar(60) NOT NULL DEFAULT '',
    newsdate date NOT NULL DEFAULT '0000-00-00',
    newstext mediumtext NOT NULL,
    PRIMARY KEY (news_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE schedule (
    schedule_id int(4) NOT NULL AUTO_INCREMENT,
    game_date date NOT NULL,
    away_team varchar(30) NOT NULL,
    home_team varchar(30) NOT NULL,
    PRIMARY KEY (schedule_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE season_days (
    days_id int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    days_date date NOT NULL,
    PRIMARY KEY (days_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE settings (
    setting_id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    display_events tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
    display_recent tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
    recent_posts tinyint(2) UNSIGNED NOT NULL DEFAULT '5',
    event_interval smallint(3) UNSIGNED NOT NULL DEFAULT '60',
    contact_email varchar(80) NOT NULL,
    PRIMARY KEY (setting_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE sitepages (
    page_id smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    page_header varchar(60) NOT NULL DEFAULT '',
    urlref varchar(60) NOT NULL DEFAULT '',
    page_contents mediumtext NOT NULL,
    display tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
    PRIMARY KEY (page_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE users (
    user_id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    username varchar(20) NOT NULL,
    password varchar(40) NOT NULL,
    access_level tinyint(1) UNSIGNED NOT NULL,
    PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

set foreign_key_checks=1;