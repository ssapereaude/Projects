/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package screens.tabs;

import javax.swing.JLabel;
import javax.swing.JPanel;
import utils.Colors;
import utils.Fonts;
import utils.Window;

public abstract class Tab extends JPanel {

    protected final int WIDTH = 860;
    protected final int PADDING_X = 100;
    protected final int PADDING_Y = 70;
    protected final int TITLE_HEIGHT = 50;

    private JLabel label;

    public Tab(String title) {
        super();
        this.setBounds(Window.WINDOW_WIDTH - WIDTH, 0, WIDTH, Window.WINDOW_HEIGHT);
        this.setBackground(Colors.BG);
        this.setLayout(null);
        label = new JLabel(title);
        label.setBounds(PADDING_X, PADDING_Y, WIDTH - 2 * PADDING_X, TITLE_HEIGHT);
        label.setForeground(Colors.TEXT);
        label.setFont(Fonts.TITLE);
        this.add(label);
    }

}
