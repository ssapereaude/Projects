/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import java.awt.Color;
import java.awt.Cursor;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.UIManager;
import utils.Colors;
import utils.Fonts;
import utils.Window;

public class OptionButton extends JButton {

    private boolean isEnabled = true;
    private OptionButton btn;
    private JLabel label;
    private int id;

    public OptionButton(String title, String icon, int width, int height, int padding, int id) {
        btn = this;
        this.id = id;
        this.setLayout(null);
        UIManager.put("Button.select", Color.TRANSLUCENT);
        this.setBorder(BorderFactory.createEmptyBorder());
        this.setFocusable(false);
        this.setForeground(Colors.TEXT);
        this.setBackground(Colors.BG_LIGHT);
        this.setFont(Fonts.DEFAULT);
        this.addMouseListener(new MouseAdapter() {
            public void mouseEntered(MouseEvent e) {
                if (isEnabled) {
                    Window.frame.setCursor(Cursor.HAND_CURSOR);
                    btn.setBackground(Colors.HIGHLIGHT);
                }
            }

            public void mouseExited(MouseEvent e) {
                Window.frame.setCursor(Cursor.DEFAULT_CURSOR);
                if (isEnabled) {
                    btn.setBackground(Colors.BG_LIGHT);
                }
            }
        });

        /* create label */
        label = new JLabel(title);
        label.setIcon(new ImageIcon("images/options/" + icon + ".png"));
        label.setIconTextGap(30);
        label.setBounds(padding, 0, width - 2 * padding, height);
        label.setFont(Fonts.DEFAULT);
        label.setForeground(Colors.TEXT);
        this.add(label);
    }

    public void setIsEnabled(boolean isEnabled) {
        this.isEnabled = isEnabled;
        this.setEnabled(isEnabled);
    }

    public String toString() {
        return id + "";
    }

}
