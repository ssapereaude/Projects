/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

import javax.swing.ImageIcon;
import javax.swing.JFrame;
import screens.Login;
import utils.Colors;
import utils.Window;

public class Driver {

    public static void main(String[] args) {

        JFrame frame = new JFrame("Casino");
        frame.setSize(Window.WINDOW_WIDTH, Window.WINDOW_HEIGHT);
        frame.setResizable(false);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.getContentPane().setBackground(Colors.BG);

        Window.frame = frame;

        ImageIcon img = new ImageIcon("images/logo.png");
        frame.setIconImage(img.getImage());

        Login loginScreen = new Login();
        frame.add(loginScreen);

        frame.setVisible(true);
    }

}
