package utils;

import javax.swing.JFrame;

import screens.Login;
import screens.MainScreen;

public class Window {

    public static final int WINDOW_WIDTH = 1200;
    public static final int WINDOW_HEIGHT = 800;

    public static JFrame frame;
    public static MainScreen mainScreen;

    public static void logOut() {
        frame.remove(mainScreen);
        frame.revalidate();
        frame.repaint();
        frame.add(new Login());
    }

}
