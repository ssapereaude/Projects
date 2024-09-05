/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import java.awt.image.BufferedImage;
import java.net.URL;
import javax.imageio.ImageIO;
import javax.swing.ImageIcon;
import javax.swing.JLabel;
import utils.Colors;
import utils.Fonts;
import utils.User;

public class Avatar extends JLabel {

    ImageIcon icon;

    public Avatar() {

        super(User.getUsername());

        try {
            /* using 'Dicebear' to get random profile image based on the username */
            URL url = new URL("https://api.dicebear.com/8.x/micah/png?radius=50&backgroundColor=555555&size=55&seed="
                    + User.getUsername());
            BufferedImage image = ImageIO.read(url);

            icon = new ImageIcon(image);
            this.setIcon(icon);
            this.setForeground(Colors.TEXT);
            this.setFont(Fonts.AVATAR);
            this.setIconTextGap(30);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

}
