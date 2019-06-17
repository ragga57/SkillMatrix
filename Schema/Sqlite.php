<?php
namespace Kanboard\Plugin\SkillMatrix\Schema;

use PDO;
const VERSION = 1;

function version_1(PDO $pdo)
{

    //$pdo->exec('ALTER TABLE users ADD COLUMN sk_role TEXT');

    
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS sk_roles (
            id INTEGER PRIMARY KEY,
            name TEXT NOT NULL,
            edit_all INTEGER DEFAULT 0,
            edit_projectmates INTEGER DEFAULT 0,
            edit_self INTEGER DEFAULT 0,
            add_tags INTEGER DEFAULT 0,
            see_tags INTEGER DEFAULT 0,
            no_tags INTEGER DEFAULT 0,
            UNIQUE(name)
        )
    ');
    $rq = $pdo->prepare('INSERT INTO sk_roles(id, name, edit_all, add_tags) VALUES ("1","app-admin","1","1")');
    $rq->execute();
    $rq = $pdo->prepare('INSERT INTO sk_roles(id, name, edit_self, no_tags) VALUES ("2","app-user","1","1")');
    $rq->execute();

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS sk_skills (
            id INTEGER PRIMARY KEY,
            name TEXT NOT NULL,
            description TEXT,
            UNIQUE(name)
        )
    ');
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS sk_tags (
            id INTEGER PRIMARY KEY,
            name TEXT NOT NULL,
            color TEXT NOT NULL,
            UNIQUE(name)
        )
    ');
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS user_has_skill (
            user_id INTEGER NOT NULL,
            skill_id INTEGER NOT NULL,
            value INTEGER,
            FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY(skill_id) REFERENCES sk_skills(id) ON DELETE CASCADE,
            UNIQUE(user_id,skill_id)
        )
    ');
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS user_has_tag (
            user_id INTEGER NOT NULL,
            tag_id INTEGER NOT NULL,
            FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY(tag_id) REFERENCES sk_tags(id) ON DELETE CASCADE,
            UNIQUE(user_id,tag_id)
        )
    ');
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS user_has_role (
            user_id INTEGER NOT NULL,
            role_id INTEGER NOT NULL,
            FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY(role_id) REFERENCES sk_roles(id) ON DELETE CASCADE,
            UNIQUE(user_id,role_id)
        )
    ');
/*
    $rq = $pdo->prepare('SELECT * FROM users');
    $rq->execute();
    $data = $rq->fetchAll();
    foreach ($data as $row) {
        $rq = $pdo->prepare('INSERT INTO sk_users(id, role) VALUES (?, ?)');
        $rq->execute(array($row['id'],$row['role']));
    }
*/

}


