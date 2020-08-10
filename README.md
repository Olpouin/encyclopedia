# Install
1. Download and put the folder somewhere in your server.
2. Create a new database with the following SQL :
```SQL
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `password` text CHARACTER SET latin1,
  `name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `type` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'b',
  `groupe` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `text` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gallery` (`id`, `password`, `name`, `type`, `groupe`, `text`, `hidden`) VALUES
(1, '', 'general', '[SERVERDATA]', '', '{\"site_name\":\"Encyclopedia\",\"box-default_image\":\"\",\"types\":{\"b\":\"Bestiaire\",\"p\":\"Personnages\",\"l\":\"Lieux\",\"e\":\"Entités\",\"s\":\"Souvenirs\"}}', 1),
(2, NULL, 'homepage', '[SERVERDATA]', '', '{\"time\":0,\"blocks\":[]}', 1);

ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `gallery`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
  COMMIT;
```
3. Configure `config/database.php`.
4. Set encrypted admin password(s) in `config/general.php`. You can use `test/password.php` to encrypt your passwords.
5. Setup your website to use the `public/` folder as root for the website.
6. Go to your website's URL. Everything should work!
# Uses
Easy way to make Wikipedia-style pages about anything. Only the home page and the pages you create, nothing more. No account system, every page can have a password and there's an admin password. Uses [EditorJS](https://github.com/codex-team/editor.js) for the editor.

**Note that this is a personal project, I am not a professional developer or anything close to that, the code will probably not be well-organized.**
