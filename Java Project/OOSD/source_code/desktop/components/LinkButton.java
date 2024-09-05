/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import java.awt.Desktop;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.net.URI;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.util.UUID;
import utils.Colors;
import utils.DB;
import utils.Fonts;
import utils.User;

public class LinkButton extends Button implements ActionListener {

    Button btn;

    public void actionPerformed(ActionEvent ev) {
        btn.setIsEnabled(false);
        btn.setBackground(Colors.PRIMARY_DARK);
        btn.setForeground(Colors.BG);

        /* create and store auth Token */
        String token = UUID.randomUUID().toString();
        System.out.println(token.length());
        try {

            /* store the auth Token in the 'tokens' table */
            Connection connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
            PreparedStatement pstat = connection.prepareStatement("INSERT INTO tokens (token, username) VALUES (?,?)");
            pstat.setString(1, token);
            pstat.setString(2, User.getUsername());

            pstat.executeUpdate();

            /* open up the website */
            URI uri = new URI("http://localhost:3000?token=" + token);
            Desktop desktop = Desktop.isDesktopSupported() ? Desktop.getDesktop() : null;
            desktop.browse(uri);

        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            btn.setIsEnabled(true);
            btn.setBackground(Colors.PRIMARY);
        }
    }

    public LinkButton(String title) {
        super(title);
        btn = this;
        super.setForeground(Colors.BG);
        super.setBackground(Colors.PRIMARY);
        super.setFont(Fonts.DEFAULT);
        super.addActionListener(this);
    }

}
